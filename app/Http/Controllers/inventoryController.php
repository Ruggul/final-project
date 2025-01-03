<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $barang = Item::with('category')->get();
        return view('factory.home', compact('barang'));
    }

    public function tambahBarang(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:items',
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        Item::create($validated);
        return redirect()->route('inventory.index')
            ->with('sukses', 'Barang berhasil ditambahkan');
    }

    public function barangMasuk(Request $request, Item $item)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required'
        ]);

        $item->stok += $validated['jumlah'];
        $item->save();

        StockMovement::create([
            'item_id' => $item->id,
            'tipe' => 'masuk',
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'user_id' => auth()->id()
        ]);

        return back()->with('sukses', 'Stok berhasil ditambahkan');
    }

    public function barangKeluar(Request $request, Item $item)
    {
        $validated = $request->validate([
            'jumlah' => "required|numeric|min:1|max:{$item->stok}",
            'keterangan' => 'required'
        ]);

        $item->stok -= $validated['jumlah'];
        $item->save();

        StockMovement::create([
            'item_id' => $item->id,
            'tipe' => 'keluar',
            'jumlah' => $validated['jumlah'],
            'keterangan' => $validated['keterangan'],
            'user_id' => auth()->id()
        ]);

        return back()->with('sukses', 'Stok berhasil dikurangi');
    }
}
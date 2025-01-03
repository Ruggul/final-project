<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        // Mengambil data atau memberikan collection kosong jika gagal
        $barang = DB::table('items')->get() ?? collect();
        
        // Kirim data ke view dengan array asosiatif
        return view('factory.home', [
            'barang' => $barang
        ]);
    }

    public function tambahBarang(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:items',
            'nama_barang' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable'
        ]);

        Item::create($validated);
        return redirect()->route('inventory.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function barangMasuk(Request $request, Item $item)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'required'
        ]);

        $item->stok += $validated['jumlah'];
        $item->save();

        return back()->with('success', 'Stok berhasil ditambahkan');
    }

    public function barangKeluar(Request $request, Item $item)
    {
        $validated = $request->validate([
            'jumlah' => "required|numeric|min:1|max:{$item->stok}",
            'keterangan' => 'required'
        ]);

        $item->stok -= $validated['jumlah'];
        $item->save();

        return back()->with('success', 'Stok berhasil dikurangi');
    }

    public function edit(Item $item)
    {
        return view('factory.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|unique:items,kode_barang,' . $item->id,
            'nama_barang' => 'required',
            'deskripsi' => 'nullable',
            'stok' => 'required|numeric|min:0',
            'satuan' => 'required',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable'
        ]);

        $item->update($validated);
        return redirect()->route('inventory.index')->with('success', 'Data barang berhasil diperbarui');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('inventory.index')->with('success', 'Barang berhasil dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        $barang = Item::where('nama_barang', 'like', "%$keyword%")
                     ->orWhere('kode_barang', 'like', "%$keyword%")
                     ->orWhere('lokasi_penyimpanan', 'like', "%$keyword%")
                     ->get();
        
        return view('factory.home', compact('barang'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:items',
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255'
        ]);

        Item::create($validated);

        return redirect()->route('inventory.index')
                        ->with('success', 'Item berhasil ditambahkan');
    }

    public function edit(Item $item)
    {
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:255|unique:items,kode_barang,' . $item->id,
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255'
        ]);

        $item->update($validated);

        return redirect()->route('inventory.index')
                        ->with('success', 'Item berhasil diupdate');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('inventory.index')
                        ->with('success', 'Item berhasil dihapus');
    }

    public function history()
    {
        // Jika Anda memiliki model untuk history pergerakan stok
        // $movements = StockMovement::with('item')->latest()->paginate(10);
        // return view('inventory.history', compact('movements'));
        
        return view('inventory.history');
    }
}
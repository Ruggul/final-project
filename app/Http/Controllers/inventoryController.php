<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // Debug untuk melihat parameter yang diterima
        \Log::info('Search params:', $request->all());

        $query = Item::query();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_barang', 'like', '%'.$search.'%')
                  ->orWhere('nama_barang', 'like', '%'.$search.'%');
            });
        }

        // Sort
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        // Validasi field sorting
        $allowedFields = ['kode_barang', 'nama_barang', 'stok', 'harga_satuan', 'created_at'];
        if (in_array($sortField, $allowedFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $items = $query->paginate(10);

        // Debug untuk melihat query yang dijalankan
        \Log::info('Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings()
        ]);

        return view('inventory.index', compact('items'));
    }

    public function create()
    {
        return view('inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:255|unique:items',
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        Item::create($request->all());

        return redirect()->route('inventory.index')
            ->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Item $item)
    {
        return view('inventory.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $request->validate([
            'kode_barang' => 'required|string|max:255|unique:items,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_satuan' => 'required|numeric|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        $item->update($request->all());

        return redirect()->route('inventory.index')
            ->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Barang berhasil dihapus');
    }

    public function history()
    {
        $items = Item::with('stockHistories')
            ->latest()
            ->paginate(10);
            
        return view('inventory.history', compact('items'));
    }
}
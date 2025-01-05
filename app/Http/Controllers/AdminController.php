<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    
    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getTotalUsers()
    {
        $totalUsers = User::count();
        return response()->json(['total' => $totalUsers]);
    }

    public function getTotalProducts()
    {
        $totalProducts = Item::count();
        return response()->json(['total' => $totalProducts]);
    }

    public function getTotalStock()
    {
        try {
            $totalStock = Item::sum('stok');
            return response()->json(['total' => $totalStock]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getLowStock()
    {
        try {
            $lowStock = Item::where('stok', '<', 10)->count();
            return response()->json(['total' => $lowStock]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getProducts()
    {
        try {
            $products = Item::all();
            return response()->json($products);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $request->validate([
                'kode_barang' => 'required|string|unique:items,kode_barang,' . $id,
                'nama_barang' => 'required|string',
                'deskripsi' => 'nullable|string',
                'stok' => 'required|integer|min:0',
                'satuan' => 'required|string',
                'harga_satuan' => 'required|numeric|min:0',
                'lokasi' => 'nullable|string'
            ]);

            $item = Item::findOrFail($id);
            
            $item->update([
                'kode_barang' => $request->kode_barang,
                'nama_barang' => $request->nama_barang,
                'deskripsi' => $request->deskripsi,
                'stok' => $request->stok,
                'satuan' => $request->satuan,
                'harga_satuan' => $request->harga_satuan,
                'lokasi_penyimpanan' => $request->lokasi
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'data' => $item
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui produk: ' . $e->getMessage()
            ], 500);
        }
    }
}

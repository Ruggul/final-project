<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

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

    public function getProduct($id)
    {
        try {
            $product = Item::findOrFail($id);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            \Log::info('Update Product Request:', [
                'id' => $id,
                'data' => $request->all()
            ]);

            $product = Item::findOrFail($id);
            
            // Validasi input
            $validated = $request->validate([
                'nama_barang' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'stok' => 'required|integer|min:0',
                'satuan' => 'required|string|max:255',
                'harga_satuan' => 'required|numeric|min:0'
            ]);

            \Log::info('Validated data:', $validated);

            $updated = $product->update($validated);

            \Log::info('Update status:', ['success' => $updated]);

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
                'updated' => $updated
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error:', $e->errors());
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Product update error:', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Failed to update product',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Item::findOrFail($id);
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\userCartManagement;

use App\Http\Controllers\Controller;
use App\Models\userCartManagement\Cart;
use App\Models\userCartManagement\Product;
use App\Models\userCartManagement\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function showCart()
    {
        $products = Product::all(); // Ambil data produk dari database
        return view('userCartManagement.cart', compact('products'));
    }

    // Menampilkan isi keranjang
    public function show($id_pengguna)
    {
        $keranjang = Cart::with('items.product')->where('id_pengguna', $id_pengguna)->first();

        if (!$keranjang) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        return response()->json($keranjang);
    }

    // Menambahkan produk ke keranjang
    public function addToCart(Request $request)
    {
        $validated = $request->validate([
            'id_pengguna' => 'required|exists:users,id',
            'id_produk' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $keranjang = Cart::firstOrCreate(['id_pengguna' => $validated['id_pengguna']]);

        $item = CartItem::updateOrCreate(
            ['id_keranjang' => $keranjang->id, 'id_produk' => $validated['id_produk']],
            ['jumlah' => \DB::raw('jumlah + ' . $validated['jumlah'])]
        );

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang', 'item' => $item]);
    }

    // Menghapus produk dari keranjang
    public function removeFromCart(Request $request)
    {
        $validated = $request->validate([
            'id_keranjang' => 'required|exists:keranjang,id',
            'id_produk' => 'required|exists:produk,id'
        ]);

        $item = CartItem::where('id_keranjang', $validated['id_keranjang'])
                        ->where('id_produk', $validated['id_produk'])
                        ->first();

        if (!$item) {
            return response()->json(['message' => 'Produk tidak ditemukan di keranjang'], 404);
        }

        $item->delete();

        return response()->json(['message' => 'Produk berhasil dihapus dari keranjang']);
    }

    // Menghapus seluruh isi keranjang
    public function clearCart($id_pengguna)
    {
        $keranjang = Cart::where('id_pengguna', $id_pengguna)->first();

        if (!$keranjang) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        $keranjang->items()->delete();

        return response()->json(['message' => 'Keranjang berhasil dikosongkan']);
    }

    // Menghitung total harga keranjang
    public function calculateTotal($id_pengguna)
    {
        $keranjang = Cart::with('items.product')->where('id_pengguna', $id_pengguna)->first();

        if (!$keranjang) {
            return response()->json(['message' => 'Keranjang tidak ditemukan'], 404);
        }

        $totalHarga = $keranjang->items->sum(function ($item) {
            return $item->jumlah * $item->product->harga;
        });

        return response()->json(['total_harga' => $totalHarga]);
    }

    // Memperbarui kuantitas produk di keranjang
    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'id_keranjang' => 'required|exists:keranjang,id',
            'id_produk' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1'
        ]);

        $item = CartItem::where('id_keranjang', $validated['id_keranjang'])
                        ->where('id_produk', $validated['id_produk'])
                        ->first();

        if (!$item) {
            return response()->json(['message' => 'Produk tidak ditemukan di keranjang'], 404);
        }

        $item->jumlah = $validated['jumlah'];
        $item->save();

        return response()->json(['message' => 'Kuantitas produk berhasil diperbarui', 'item' => $item]);
    }
}



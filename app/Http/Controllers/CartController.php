<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() // Menampilkan halaman keranjang
    {
        // Mengambil cart dari session
        $cartItems = session()->get('cart', []);
        $total = 0;

        // Mengambil detail produk untuk setiap item di cart
        foreach($cartItems as $id => $details) {
            $total += $details['price'] * $details['quantity'];
        }

        return view('cart', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $item = Item::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if(isset($cart[$item->id])) {
            $cart[$item->id]['quantity']++;
        } else {
            $cart[$item->id] = [
                "name" => $item->nama_barang,
                "kode_barang" => $item->kode_barang,
                "quantity" => 1,
                "price" => $item->harga_satuan,
                "satuan" => $item->satuan,
                "lokasi" => $item->lokasi_penyimpanan,
                "stok" => $item->stok
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request) // Memperbarui jumlah item di keranjang
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    public function clear() // Menghapus semua item di keranjang
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan!');
    }

    public function checkout(Request $request)
    {
        try {
            // Validasi stok sebelum checkout
            $cart = session()->get('cart', []);
            foreach($cart as $id => $details) {
                $item = Item::find($id);
                if(!$item || $item->stok < $details['quantity']) {
                    return redirect()->back()->with('error', 'Stok ' . ($item->nama_barang ?? 'produk') . ' tidak mencukupi');
                }
            }

            // Buat order baru
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => array_sum(array_map(function($item) {
                    return $item['price'] * $item['quantity'];
                }, $cart)),
                'status' => 'pending'
            ]);

            // Simpan detail order
            foreach($cart as $id => $details) {
                $item = Item::find($id);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'item_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'subtotal' => $details['price'] * $details['quantity']
                ]);

                // Kurangi stok
                $item->decrement('stok', $details['quantity']);
            }

            // Kosongkan cart
            session()->forget('cart');

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat checkout. Silakan coba lagi.');
        }
    }

    public function showOrder(Order $order) // Menampilkan detail order
    {
        // Pastikan user hanya bisa melihat ordernya sendiri
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }
}



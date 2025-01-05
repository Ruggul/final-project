<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Ambil items dari cart
            $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
            
            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjang kosong');
            }

            // Hitung total
            $total = $cartItems->sum(function($item) {
                return $item->product->price * $item->quantity;
            });

            // Buat order baru
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . Str::random(10),
                'total_amount' => $total,
                'status' => 'pending'
            ]);

            // Debug log
            \Log::info('Creating new order:', [
                'order_id' => $order->id,
                'cart_items' => $cartItems->toArray()
            ]);

            // Simpan items dari cart ke order_items
            foreach($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Debug log
            \Log::info('Order items created:', [
                'order_id' => $order->id,
                'items' => $order->items()->with('product')->get()->toArray()
            ]);

            // Kosongkan cart
            Cart::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                           ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating order: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat membuat pesanan');
        }
    }

    public function show(Order $order)
    {
        // Debug log
        \Log::info('Showing order:', [
            'order_id' => $order->id,
            'has_items' => $order->items()->exists(),
            'items_count' => $order->items()->count()
        ]);

        // Load order dengan items dan products
        $order->load(['items.product']);

        // Debug log setelah loading
        \Log::info('Order loaded:', [
            'order_id' => $order->id,
            'items' => $order->items->toArray()
        ]);

        return view('orders.show', compact('order'));
    }
} 
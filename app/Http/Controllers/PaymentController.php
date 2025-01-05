<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout($order_id)
    {
        try {
            // Load order dengan items dan products
            $order = Order::with(['details.item'])->findOrFail($order_id);
            
            // Debug log
            \Log::info('Checkout initiated:', [
                'order_id' => $order_id,
                'order' => $order->toArray()
            ]);

            return view('payments.checkout', [
                'order' => $order,
                'total' => $order->total_amount
            ]);

        } catch (\Exception $e) {
            \Log::error('Error in checkout: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat checkout');
        }
    }

    public function process(Request $request)
    {
        try {
            $request->validate([
                'payment_method' => 'required|in:bank_transfer,qris,e_wallet',
                'bank_name' => 'required_if:payment_method,bank_transfer',
                'e_wallet_type' => 'required_if:payment_method,e_wallet',
                'total_amount' => 'required|numeric',
                'order_id' => 'required|exists:orders,id'
            ]);

            // Ambil order
            $order = Order::findOrFail($request->order_id);

            // Buat payment record
            $payment = Payment::create([
                'order_id' => $order->id,
                'amount' => $request->total_amount,
                'payment_method' => $request->payment_method,
                'payment_details' => [
                    'bank_name' => $request->bank_name,
                    'e_wallet_type' => $request->e_wallet_type,
                ],
                'status' => 'pending',
                'transaction_id' => 'TRX-' . Str::random(10)
            ]);

            // Update order status
            $order->update(['status' => 'awaiting_payment']);

            return redirect()->route('payments.show', $payment)
                           ->with('success', 'Silakan selesaikan pembayaran Anda');

        } catch (\Exception $e) {
            \Log::error('Error in payment process: ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memproses pembayaran')
                           ->withInput();
        }
    }

    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }
} 
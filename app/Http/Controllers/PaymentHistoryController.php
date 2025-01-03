<?php

namespace App\Http\Controllers;

use App\Models\PaymentHistory;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    //Menampilkan daftar riwayat pembayaran
    public function index()
    {
        $payments = PaymentHistory::latest()->paginate(10);

        return view('payment-history.index', compact('payments'));
    }

    //Menampilkan form tambah pembayaran
    public function create()
    {
        return view('payment-history.create');
    }

    //Menyimpan data pembayaran baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:payment_history',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet,other',
            'payment_date' => 'required|date',
            'due_date' => 'required|date',
            'description' => 'nullable'
        ]);

        PaymentHistory::create($validated);

        return redirect()
            ->route('payment-history.index')
            ->with('success', 'Payment added successfully');
    }

    //Menampilkan detail pembayaran
    public function show(PaymentHistory $paymentHistory)
    {
        return view('payment-history.show', compact('paymentHistory'));
    }

    //Menampilkan form edit pembayaran
    public function edit(PaymentHistory $paymentHistory)
    {
        return view('payment-history.edit', compact('paymentHistory'));
    }

    //Mengupdate data pembayaran
    public function update(Request $request, PaymentHistory $paymentHistory)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|unique:payment_history,invoice_number,' . $paymentHistory->id,
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet,other',
            'payment_date' => 'required|date',
            'due_date' => 'required|date',
            'description' => 'nullable'
        ]);

        $paymentHistory->update($validated);

        return redirect()
            ->route('payment-history.index')
            ->with('success', 'Payment updated successfully');
    }

    //Menghapus data pembayaran
    public function destroy(PaymentHistory $paymentHistory)
    {
        $paymentHistory->delete();

        return redirect()
            ->route('payment-history.index')
            ->with('success', 'Payment deleted successfully');
    }
}
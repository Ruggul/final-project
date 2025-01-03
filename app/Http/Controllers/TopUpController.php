<?php

namespace App\Http\Controllers;

use App\Models\TopUp;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    /**
     * Display a listing of topups.
     */
    public function index()
    {
        $topups = TopUp::where('user_id', auth()->id())
                       ->latest()
                       ->paginate(10);

        return view('user.topup', compact('topups'));
    }

    /**
     * Show the form for creating a new topup.
     */
    public function create()
    {
        return view('user.topup-create');
    }

    /**
     * Store a newly created topup.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:bank_transfer,credit_card,e-wallet',
        ]);

        $topup = TopUp::create([
            'user_id' => auth()->id(),
            'transaction_number' => 'TU' . time() . rand(1000, 9999),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
        ]);

        return redirect()->route('topups.show', $topup)
                        ->with('success', 'Top up request created successfully.');
    }

    /**
     * Display the specified topup.
     */
    public function show(TopUp $topup)
    {
        // Ensure user can only see their own topups
        if ($topup->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.topup-show', compact('topup'));
    }

    /**
     * Cancel a pending topup.
     */
    public function cancel(TopUp $topup)
    {
        // Ensure user can only cancel their own pending topups
        if ($topup->user_id !== auth()->id() || $topup->status !== 'pending') {
            abort(403);
        }

        $topup->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('topups.index')
                        ->with('success', 'Top up cancelled successfully.');
    }

    /**
     * Verify payment for a topup.
     */
    public function verify(Request $request, TopUp $topup)
    {
        // Ensure user can only verify their own pending topups
        if ($topup->user_id !== auth()->id() || $topup->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048',
        ]);

        // Handle payment proof upload
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $topup->update([
            'payment_proof' => $path,
            'status' => 'verifying',
            'payment_date' => now(),
        ]);

        return redirect()->route('topups.index')
                        ->with('success', 'Payment proof submitted successfully.');
    }
}
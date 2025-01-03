<?php

namespace App\Http\Controllers;

use App\Models\Topup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopupController extends Controller
{
    /**
     * Display a listing of topups
     */
    public function index()
    {
        $topups = Topup::with('user')
                       ->latest()
                       ->paginate(10);
                       
        return view('topups.index', compact('topups'));
    }

    /**
     * Show the form for creating a new topup
     */
    public function create()
    {
        return view('topups.create');
    }

    /**
     * Store a newly created topup
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:' . Topup::PAYMENT_BANK_TRANSFER . ',' . Topup::PAYMENT_E_WALLET,
        ]);

        $topup = Topup::create([
            'user_id' => auth()->id(),
            'transaction_number' => 'TRX-' . Str::random(10),
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => Topup::STATUS_PENDING,
            'payment_date' => now(),
        ]);

        return redirect()
            ->route('topups.show', $topup)
            ->with('success', 'Topup request created successfully');
    }

    /**
     * Display the specified topup
     */
    public function show(Topup $topup)
    {
        return view('topups.show', compact('topup'));
    }

    /**
     * Update the specified topup status
     */
    public function updateStatus(Request $request, Topup $topup)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . Topup::STATUS_SUCCESS . ',' . Topup::STATUS_FAILED,
        ]);

        $topup->update([
            'status' => $validated['status'],
            'payment_date' => $validated['status'] === Topup::STATUS_SUCCESS ? now() : null,
        ]);

        return redirect()
            ->route('topups.show', $topup)
            ->with('success', 'Topup status updated successfully');
    }

    //Cancel the specified topup
    public function cancel(Topup $topup)
    {
        if ($topup->status === Topup::STATUS_PENDING) {
            $topup->update([
                'status' => Topup::STATUS_FAILED,
            ]);

            return redirect()
                ->route('topups.index')
                ->with('success', 'Topup cancelled successfully');
        }

        return redirect()
            ->route('topups.show', $topup)
            ->with('error', 'Cannot cancel this topup');
    }

    //Get user's topup history
    public function history()
    {
        $topups = Topup::where('user_id', auth()->id())
                       ->latest()
                       ->paginate(10);

        return view('topups.history', compact('topups'));
    }
}
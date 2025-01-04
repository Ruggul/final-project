<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopUp;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function index()
    {
        $topups = TopUp::where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();
        return view('topups.index', compact('topups'));
    }

    public function create()
    {
        try {
            // Mengambil data user yang sedang login
            $user = Auth::user();
            
            // Mengambil riwayat topup user
            $topups = TopUp::where('user_id', $user->id)
                          ->orderBy('created_at', 'desc')
                          ->take(5)
                          ->get();

            // Mengambil saldo user saat ini
            $currentBalance = $user->balance;

            // Return view dengan data yang diperlukan
            return view('user.topup', [
                'user' => $user,
                'topups' => $topups,
                'currentBalance' => $currentBalance
            ]);

        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            \Log::error('Error in TopUpController@create: ' . $e->getMessage());
            
            // Redirect dengan pesan error
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'payment_method' => 'required|in:bank_transfer,e_wallet'
        ]);

        $topup = TopUp::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        return redirect()->route('topups.show', $topup)
                        ->with('success', 'TopUp berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(TopUp $topup)
    {
        if ($topup->user_id !== Auth::id()) {
            abort(403);
        }

        return view('topups.show', compact('topup'));
    }

    public function verify(TopUp $topup)
    {
        $topup->update(['status' => 'success']);

        $user = Auth::user();
        $user->balance += $topup->amount;
        $user->save();

        return redirect()->route('topups.show', $topup)
                        ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function cancel(TopUp $topup)
    {
        if ($topup->status === 'pending') {
            $topup->update(['status' => 'cancelled']);
        }

        return redirect()->route('topups.index')
                        ->with('success', 'TopUp dibatalkan.');
    }
}
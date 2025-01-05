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
            'payment_method' => 'required|in:e_wallet,bank_transfer,cash', // Sesuaikan dengan opsi valid
        ]);
    
        // Tambahkan logging untuk debugging
        \Log::info('Payment Method: ' . $request->payment_method);
        \Log::info('Amount: ' . $request->amount);
    
        try {
            // Simpan data ke database
            TopUp::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);
    
            return redirect()->back()->with('success', 'Top-up berhasil!');
        } catch (\Exception $e) {
            \Log::error('Error in TopUpController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
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

    public function history()
    {
        // Jika Anda memiliki model untuk history pergerakan stok
        // $movements = StockMovement::with('item')->latest()->paginate(10);
        // return view('inventory.history', compact('movements'));
        
        return view('topups.history');
    }
}
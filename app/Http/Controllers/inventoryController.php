<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\StockMovement;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // Method yang sudah ada sebelumnya
    public function index()
    {
        // ... kode sebelumnya ...
    }

    // Fungsi untuk filter data berdasarkan periode
    public function filterByPeriod(Request $request)
    {
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $data = [
            'stock_movements' => StockMovement::whereBetween('created_at', [$startDate, $endDate])
                ->with(['item', 'user'])
                ->get(),
            'total_masuk' => StockMovement::whereBetween('created_at', [$startDate, $endDate])
                ->where('tipe', 'masuk')
                ->sum('jumlah'),
            'total_keluar' => StockMovement::whereBetween('created_at', [$startDate, $endDate])
                ->where('tipe', 'keluar')
                ->sum('jumlah'),
        ];

        return response()->json($data);
    }

    // Fungsi untuk mendapatkan statistik kategori
    public function getCategoryStatistics()
    {
        $categoryStats = Category::withCount('items')
            ->withSum('items', 'stok')
            ->get()
            ->map(function ($category) {
                return [
                    'name' => $category->name,
                    'total_items' => $category->items_count,
                    'total_stock' => $category->items_sum_stok,
                ];
            });

        return response()->json($categoryStats);
    }

    // Fungsi untuk mendapatkan top items (paling sering keluar/masuk)
    public function getTopItems()
    {
        $topItemsOut = StockMovement::where('tipe', 'keluar')
            ->select('item_id', DB::raw('SUM(jumlah) as total_keluar'))
            ->with('item:id,nama_barang,kode_barang')
            ->groupBy('item_id')
            ->orderByDesc('total_keluar')
            ->limit(5)
            ->get();

        $topItemsIn = StockMovement::where('tipe', 'masuk')
            ->select('item_id', DB::raw('SUM(jumlah) as total_masuk'))
            ->with('item:id,nama_barang,kode_barang')
            ->groupBy('item_id')
            ->orderByDesc('total_masuk')
            ->limit(5)
            ->get();

        return response()->json([
            'top_keluar' => $topItemsOut,
            'top_masuk' => $topItemsIn
        ]);
    }

    // Fungsi untuk mendapatkan status pembayaran
    public function getPaymentStatus()
    {
        $paymentStatus = Payment::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        $totalAmount = Payment::select(
                DB::raw('SUM(CASE WHEN status = "paid" THEN amount ELSE 0 END) as total_paid'),
                DB::raw('SUM(CASE WHEN status = "pending" THEN amount ELSE 0 END) as total_pending')
            )
            ->first();

        return response()->json([
            'status_count' => $paymentStatus,
            'total_amount' => $totalAmount
        ]);
    }

    // Fungsi untuk mendapatkan tren stok harian
    public function getDailyStockTrend()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(30);

        $dailyTrend = StockMovement::where('created_at', '>=', $thirtyDaysAgo)
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(CASE WHEN tipe = "masuk" THEN jumlah ELSE -jumlah END) as net_change')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json($dailyTrend);
    }

    // Fungsi untuk mendapatkan ringkasan dokumen
    public function getDocumentSummary()
    {
        $documents = DB::table('documents')
            ->select('type', DB::raw('COUNT(*) as total'))
            ->groupBy('type')
            ->get();

        $recentDocuments = DB::table('documents')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return response()->json([
            'summary' => $documents,
            'recent' => $recentDocuments
        ]);
    }
}

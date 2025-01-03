@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5>Total Items</h5>
                    <h3>{{ $totalItems }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5>Total Categories</h5>
                    <h3>{{ $totalCategories }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <h5>Low Stock Items</h5>
                    <h3>{{ $lowStockItems }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">
                    <h5>Recent Transactions</h5>
                    <h3>{{ $recentTransactions }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row mt-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Stock Movements</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Tipe</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentMovements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('d/m/Y') }}</td>
                                <td>{{ $movement->item->nama_barang }}</td>
                                <td>
                                    <span class="badge {{ $movement->tipe === 'masuk' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($movement->tipe) }}
                                    </span>
                                </td>
                                <td>{{ $movement->jumlah }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Payments</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Invoice</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentPayments as $payment)
                            <tr>
                                <td>{{ $payment->payment_date->format('d/m/Y') }}</td>
                                <td>{{ $payment->invoice_number }}</td>
                                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge {{ $payment->status === 'paid' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Contoh pemanggilan API
fetch('/dashboard/top-items')
    .then(response => response.json())
    .then(data => {
        // Update UI dengan data yang diterima
        updateTopItemsChart(data);
    });

// Contoh filter periode
document.getElementById('filter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('/dashboard/filter?' + new URLSearchParams(formData))
        .then(response => response.json())
        .then(data => {
            // Update UI dengan data yang difilter
            updateDashboardData(data);
        });
});
</script>
@endsection
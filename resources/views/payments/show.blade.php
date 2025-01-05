<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembayaran - TradeGate</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('user.component.header')

    <div class="container mx-auto px-4 pt-24">
        <div class="max-w-2xl mx-auto">
            <!-- Payment Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-semibold mb-6">Detail Pembayaran</h2>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Transaksi</span>
                        <span class="font-medium">{{ $payment->transaction_id }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pembayaran</span>
                        <span class="font-medium">Rp {{ number_format($payment->amount) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode Pembayaran</span>
                        <span class="font-medium">
                            {{ $payment->payment_method === 'bank_transfer' ? 'Transfer Bank' : 
                               ($payment->payment_method === 'qris' ? 'QRIS' : 'E-Wallet') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-600">Status</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $payment->status === 'success' ? 'bg-green-100 text-green-800' : 
                               ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-medium mb-4">Instruksi Pembayaran</h3>
                    @if($payment->payment_method === 'bank_transfer')
                        <div class="space-y-2">
                            <p>Transfer ke rekening:</p>
                            <p class="font-medium">Bank {{ ucfirst($payment->payment_details['bank_name']) }}</p>
                            <p>No. Rekening: 1234567890</p>
                            <p>Atas Nama: TradeGate</p>
                        </div>
                    @elseif($payment->payment_method === 'qris')
                        <div class="text-center">
                            <p class="mb-4">Scan QRIS code berikut:</p>
                            <div class="flex justify-center">
                                <img src="{{ asset('design/TradeGateQR.png') }}" 
                                     alt="QRIS Code" 
                                     class="w-64 h-64 object-contain border-2 border-gray-200 rounded-lg">
                            </div>
                            <p class="mt-4 text-sm text-gray-600">
                                Buka aplikasi e-wallet Anda dan scan QR code di atas
                            </p>
                        </div>
                    @else
                        <div class="space-y-2">
                            <p>Pembayaran melalui {{ $payment->payment_details['e_wallet_type'] }}</p>
                            <p>Silakan buka aplikasi {{ $payment->payment_details['e_wallet_type'] }} Anda</p>
                        </div>
                    @endif
                </div>

                <!-- Back Button -->
                <div class="mt-8">
                    <a href="{{ url('/redirect') }}" 
                       class="block w-full bg-gray-200 text-gray-800 text-center py-3 rounded-lg hover:bg-gray-300 transition-colors">
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 
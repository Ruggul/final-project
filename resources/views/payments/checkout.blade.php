<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TradeGate</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    @include('user.component.header')

    <div class="container mx-auto px-4 pt-24">
        <div class="max-w-4xl mx-auto">
            <!-- Order Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-semibold mb-4">Ringkasan Pesanan</h2>
                
                <div class="divide-y divide-gray-200">
                    @if(isset($order))
                        <!-- Detail Items -->
                        @foreach($order->details as $detail)
                            <div class="py-4 flex justify-between items-center">
                                <div class="flex-1">
                                    <h3 class="font-medium">{{ $detail->item->nama_barang }}</h3>
                                    <p class="text-gray-500">{{ $detail->quantity }} x Rp {{ number_format($detail->price) }}</p>
                                </div>
                                <span class="font-medium ml-4">Rp {{ number_format($detail->subtotal) }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="mt-6 pt-6 border-t">
                    <div class="flex justify-between text-xl font-semibold">
                        <span>Total</span>
                        <span>Rp {{ number_format($total) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <form action="{{ route('payments.process') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
                @csrf
                <input type="hidden" name="total_amount" value="{{ $total }}">
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <h2 class="text-2xl font-semibold mb-4">Metode Pembayaran</h2>

                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-4">
                    <!-- Bank Transfer -->
                    <div class="border rounded-lg p-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" 
                                   class="mr-3" required>
                            <span class="font-medium">Transfer Bank</span>
                        </label>
                        <div class="mt-4">
                            <select name="bank_name" class="w-full border rounded-lg p-2">
                                <option value="bca">BCA</option>
                                <option value="mandiri">Mandiri</option>
                                <option value="bni">BNI</option>
                            </select>
                        </div>
                    </div>

                    <!-- QRIS -->
                    <label class="flex items-center border rounded-lg p-4 cursor-pointer">
                        <input type="radio" name="payment_method" value="qris" class="mr-3" required>
                        <span class="font-medium">QRIS</span>
                    </label>

                    <!-- E-Wallet -->
                    <div class="border rounded-lg p-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="payment_method" value="e_wallet" 
                                   class="mr-3" required>
                            <span class="font-medium">E-Wallet</span>
                        </label>
                        <div class="mt-4">
                            <select name="e_wallet_type" class="w-full border rounded-lg p-2">
                                <option value="gopay">GoPay</option>
                                <option value="ovo">OVO</option>
                                <option value="dana">DANA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full mt-6 bg-blue-700 text-white py-3 rounded-lg hover:bg-blue-800 transition-colors">
                    Bayar Sekarang
                </button>
            </form>
        </div>
    </div>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html> 
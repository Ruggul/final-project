<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopUp - TradeGate</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
    <body class="bg-gray-100">
        @include('user.component.header')

    <div class="container mx-auto px-4 pt-24">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-6">TopUp Saldo</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('topups.store') }}" method="POST">
                @csrf

                <!-- Jumlah TopUp -->
                <div class="mb-4">
                    <label for="amount" class="block text-gray-700 font-medium mb-2">Jumlah TopUp</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-600">Rp</span>
                        <input type="number" 
                               name="amount" 
                               id="amount" 
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               min="10000"
                               value="{{ old('amount') }}"
                               required>
                    </div>
                    <p class="text-sm text-gray-500 mt-1">Minimal Rp 10.000</p>
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran</label>
                    <div class="space-y-2">
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="bank_transfer" 
                                   class="mr-3" 
                                   {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}
                                   required>
                            <span>Transfer Bank</span>
                        </label>
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                            <input type="radio" 
                                   name="payment_method" 
                                   value="e_wallet" 
                                   class="mr-3"
                                   {{ old('payment_method') == 'e_wallet' ? 'checked' : '' }}>
                            <span>E-Wallet</span>
                        </label>
                    </div>
                </div>

                <!-- Button Submit -->
                <button type="submit" 
                        class="w-full bg-blue-700 text-white py-2 px-4 rounded-lg hover:bg-blue-800 transition-colors">
                    Lanjutkan Pembayaran
                </button>
            </form>
        </div>
    </div>
</body>
</html>
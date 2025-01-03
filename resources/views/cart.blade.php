<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-green-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/redirect') }}" class="flex items-center">
                <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Logo" 
                     class="h-8 filter brightness-0 invert">
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Keranjang Belanja</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cartItems) > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-4">Kode</th>
                            <th class="text-left py-4">Produk</th>
                            <th class="text-center py-4">Harga</th>
                            <th class="text-center py-4">Jumlah</th>
                            <th class="text-center py-4">Total</th>
                            <th class="text-center py-4">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $id => $details)
                            <tr class="border-b">
                                <td class="py-4">
                                    {{ $details['kode_barang'] }}
                                </td>
                                <td class="py-4">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $details['name'] }}</span>
                                        <span class="text-sm text-gray-500">{{ $details['lokasi'] }}</span>
                                    </div>
                                </td>
                                <td class="text-center py-4">
                                    Rp {{ number_format($details['price']) }}
                                </td>
                                <td class="text-center py-4">
                                    <div class="flex items-center justify-center">
                                        <form action="{{ route('cart.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="number" name="quantity" value="{{ $details['quantity'] }}" 
                                                   class="w-20 text-center border rounded px-2 py-1"
                                                   min="1">
                                            <span class="ml-2">{{ $details['satuan'] }}</span>
                                            <button type="submit" class="ml-2 text-blue-600">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="text-center py-4">
                                    Rp {{ number_format($details['price'] * $details['quantity']) }}
                                </td>
                                <td class="text-center py-4">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-6 flex justify-between items-center">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Kosongkan Keranjang
                        </button>
                    </form>

                    <div class="text-right">
                        <p class="text-lg font-bold">Total: Rp {{ number_format($total) }}</p>
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <p class="text-gray-500 mb-4">Keranjang belanja Anda kosong</p>
                <a href="{{ url('/redirect') }}" class="text-green-600 hover:text-green-700">
                    Lanjutkan Belanja
                </a>
            </div>
        @endif
    </div>
</body>
</html>

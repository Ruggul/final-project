<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-blue-700 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/redirect') }}" class="flex items-center">
                <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Logo" 
                     class="h-8 filter brightness-0 invert">
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Detail Pemesanan #{{ $order->id }}</h1>

            @if(session('success'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Informasi Pemesanan -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Informasi Pemesanan</h2>
                <p>Tanggal: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</p>
                <p>Status: <span class="font-semibold">{{ ucfirst($order->status) }}</span></p>
            </div>

            <!-- Detail Item -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-2">Item yang Dipesan</h2>
                <table class="w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Produk</th>
                            <th class="text-center py-2">Harga</th>
                            <th class="text-center py-2">Jumlah</th>
                            <th class="text-right py-2">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $detail)
                            <tr class="border-b">
                                <td class="py-2">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $detail->item->nama_barang }}</span>
                                        <span class="text-sm text-gray-500">{{ $detail->item->kode_barang }}</span>
                                    </div>
                                </td>
                                <td class="text-center py-2">Rp {{ number_format($detail->price) }}</td>
                                <td class="text-center py-2">{{ $detail->quantity }} {{ $detail->item->satuan }}</td>
                                <td class="text-right py-2">Rp {{ number_format($detail->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td colspan="3" class="text-right py-4">Total:</td>
                            <td class="text-right py-4">Rp {{ number_format($order->total_amount) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Tombol Kembali -->
            <div class="text-center">
                <a href="{{ url('/redirect') }}" 
                   class="inline-block bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800">
                    Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
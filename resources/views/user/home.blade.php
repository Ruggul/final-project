<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="ml-64 flex-1">
        @include('user.components.header')
        
    <!-- Navbar -->
    <nav class="bg-green-600 text-white p-4 fixed w-full z-50">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-8">
                <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Logo" class="h-8 filter brightness-0 invert">
                <div class="flex-1 max-w-2xl">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk" class="w-full px-4 py-2 rounded-lg text-gray-900 focus:outline-none">
                        <button class="absolute right-0 top-0 h-full px-4 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{route('cart')}}" class="hover:text-gray-200">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </a>
                <a href="#" class="hover:text-gray-200">
                    <i class="fas fa-bell text-xl"></i>
                </a>
                <a href="#" class="hover:text-gray-200">
                    <i class="fas fa-user text-xl"></i>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto pt-24 px-4">
        <!-- Categories -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Kategori</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
                <a href="#" class="flex flex-col items-center p-2 hover:bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-tshirt text-blue-500"></i>
                    </div>
                    <span class="text-sm text-gray-600">Fashion</span>
                </a>
                <a href="#" class="flex flex-col items-center p-2 hover:bg-gray-50 rounded-lg">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-mobile-alt text-green-500"></i>
                    </div>
                    <span class="text-sm text-gray-600">Elektronik</span>
                </a>
                <!-- Add more categories as needed -->
            </div>
        </div>

        <!-- Flash Sale -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Flash Sale</h2>
                <a href="#" class="text-green-600 hover:text-green-700">Lihat Semua</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @if(isset($flashSaleProducts))
                    <!-- {{ $flashSaleProducts->count() }} items found -->
                @else
                    <!-- Variable $flashSaleProducts not found -->
                @endif
                @foreach($flashSaleProducts as $product)
                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">{{ $product->nama_barang }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $product->deskripsi }}</p>
                        <p class="text-lg font-bold text-green-600">Rp {{ number_format($product->harga_satuan) }}</p>
                        <p class="text-sm text-gray-500">Stok: {{ $product->stok }} {{ $product->satuan }}</p>
                        <p class="text-xs text-gray-400">{{ $product->lokasi_penyimpanan }}</p>
                        
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recommended Products -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Rekomendasi Untukmu</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($recommendedProducts as $product)
                <div class="border rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">{{ $product->nama_barang }}</h3>
                        <p class="text-xs text-gray-500 mb-2">{{ $product->deskripsi }}</p>
                        <p class="text-lg font-bold text-green-600">Rp {{ number_format($product->harga_satuan) }}</p>
                        <p class="text-sm text-gray-500">Stok: {{ $product->stok }} {{ $product->satuan }}</p>
                        <p class="text-xs text-gray-400">{{ $product->lokasi_penyimpanan }}</p>
                        
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
                                Tambah ke Keranjang
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white mt-8 py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-semibold mb-4">Layanan Pelanggan</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-green-600">Bantuan</a></li>
                        <li><a href="#" class="hover:text-green-600">Cara Pembelian</a></li>
                        <li><a href="#" class="hover:text-green-600">Pengiriman</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Tentang Kami</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="#" class="hover:text-green-600">Tentang</a></li>
                        <li><a href="#" class="hover:text-green-600">Karir</a></li>
                        <li><a href="#" class="hover:text-green-600">Blog</a></li>
                    </ul>
                </div>
                <!-- Add more footer sections as needed -->
            </div>
        </div>
    </footer>
</body>
</html>

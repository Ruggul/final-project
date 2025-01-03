<div class="w-64 h-screen bg-gray-800 fixed">
    <div class="flex items-center justify-center h-20 shadow-md">
        <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Tradegate Logo" class="h-12">
    </div>
    <nav class="mt-5">
        <a href="#" onclick="showContent('overview')" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
            <i class="fas fa-home mr-3"></i>
            Overview
        </a>
        <a href="#" onclick="showContent('users')" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
            <i class="fas fa-users mr-3"></i>
            Daftar User
        </a>
        <a href="#" onclick="showContent('products')" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
            <i class="fas fa-box mr-3"></i>
            Daftar Produk
        </a>
        <a href="#" onclick="showContent('statistics')" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
            <i class="fas fa-chart-bar mr-3"></i>
            Statistika
        </a>
    </nav>
</div> 
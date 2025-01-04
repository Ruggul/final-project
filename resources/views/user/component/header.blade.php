<nav class="bg-blue-700 text-white p-4 fixed w-full z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <a href="{{ route('redirect') }}" class="flex items-center">
            <img src="{{ asset('design/tradeGateLogo.png') }}" alt="Logo" 
                 class="h-8 filter brightness-0 invert">
        </a>

        <!-- Menu Kanan -->
        <div class="flex items-center space-x-4">
            <!-- Cart -->
            <a href="{{ route('cart') }}" class="text-white hover:text-gray-200">
                <i class="fas fa-shopping-cart text-xl"></i>
            </a>

            <!-- Documents -->
            <a href="{{ route('documents.index') }}" class="text-white hover:text-gray-200">
                <i class="fas fa-file-alt text-xl"></i>
            </a>

            <!-- Inventory -->
            <a href="{{ route('inventory.index') }}" class="text-white hover:text-gray-200">
                <i class="fas fa-box text-xl"></i>
            </a>

            <!-- User Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center space-x-2 text-white hover:text-gray-200">
                    <span>{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open" 
                     @click.away="open = false" 
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                    <!-- TopUp -->
                    <a href="{{ route('topups.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        TopUp History
                    </a>
                    <a href="{{ route('topups.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        TopUp
                    </a>
                    
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Dashboard
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav> 
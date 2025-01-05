@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed w-64 h-full bg-gray-800">
        <div class="flex items-center justify-center h-20 shadow-md">
            <h1 class="text-3xl uppercase text-white">Factory</h1>
        </div>

        <nav class="py-5">
            <!-- Inventory Management Menu -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between text-gray-100 px-6 py-3 hover:bg-gray-700">
                    <span class="flex items-center">
                        <i class="fas fa-box mr-3"></i>
                        Inventory
                    </span>
                    <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                </button>
                <div x-show="open" class="bg-gray-700">
                    <a href="{{ route('inventory.index') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-list mr-3"></i>Stock List
                    </a>
                    <a href="{{ route('inventory.create') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-plus mr-3"></i>Add Item
                    </a>
                    <a href="{{ route('inventory.history') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-history mr-3"></i>Stock History
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-md">
            <div class="flex justify-between items-center py-4 px-6">
                <h2 class="text-xl font-semibold">Factory Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <div class="container mx-auto px-6 py-8">
                <!-- Dashboard Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Total Items Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Total Items</h3>
                                <span class="text-2xl font-bold">{{ $totalItems ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Low Stock Items Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <i class="fas fa-exclamation-triangle fa-2x"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Low Stock Items</h3>
                                <span class="text-2xl font-bold">{{ $lowStockItems ?? 0 }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities Card -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-history fa-2x"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Recent Activities</h3>
                                <span class="text-2xl font-bold">{{ $recentActivities ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Stock Movement -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Recent Stock Movement</h3>
                    <div class="bg-white rounded-lg shadow-md">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($recentMovements ?? [] as $movement)
                                <tr>
                                    <td class="px-6 py-4">{{ $movement->item_name }}</td>
                                    <td class="px-6 py-4">{{ $movement->type }}</td>
                                    <td class="px-6 py-4">{{ $movement->quantity }}</td>
                                    <td class="px-6 py-4">{{ $movement->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        No recent movements
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
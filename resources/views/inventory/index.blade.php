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
            <div x-data="{ open: true }">
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
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600 bg-gray-600">
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
                <h2 class="text-xl font-semibold">Inventory List</h2>
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
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="p-4 flex justify-between items-center border-b">
                        <h3 class="text-lg font-semibold">Stock Items</h3>
                        <a href="{{ route('inventory.create') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors duration-200">
                            <i class="fas fa-plus mr-2"></i>Add New Item
                        </a>
                    </div>

                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga Satuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($items as $item)
                                <tr>
                                    <td class="px-6 py-4">{{ $item->kode_barang }}</td>
                                    <td class="px-6 py-4">{{ $item->nama_barang }}</td>
                                    <td class="px-6 py-4">{{ $item->stok }}</td>
                                    <td class="px-6 py-4">{{ $item->satuan }}</td>
                                    <td class="px-6 py-4">Rp {{ number_format($item->harga_satuan) }}</td>
                                    <td class="px-6 py-4">{{ $item->lokasi_penyimpanan }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('inventory.edit', $item) }}" 
                                               class="text-blue-500 hover:text-blue-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('inventory.destroy', $item) }}" 
                                                  class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                        No items found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="px-6 py-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection 
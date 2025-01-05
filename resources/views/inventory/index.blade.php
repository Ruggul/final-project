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

            <!-- Document Menu -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between text-gray-100 px-6 py-3 hover:bg-gray-700">
                    <span class="flex items-center">
                        <i class="fas fa-file-invoice fa-lg mr-3"></i>
                        Documents
                    </span>
                    <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                </button>
                <div x-show="open" class="bg-gray-700">
                    <a href="{{ route('documents.index') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-file-alt mr-3"></i>Document List
                    </a>
                    <a href="{{ route('documents.create') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-file-medical mr-3"></i>Add Document
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
                <h2 class="text-xl font-semibold">Stock List</h2>
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
                <div class="bg-white rounded-lg shadow-md p-6">
                    <!-- Filter dan Sorting -->
                    <div class="mb-4 flex flex-wrap gap-4">
                        <form action="{{ route('inventory.index') }}" method="GET" class="flex flex-wrap gap-4 w-full">
                            <!-- Search Input -->
                            <div class="flex-1 min-w-[200px]">
                                <input type="text" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Cari barang..." 
                                       class="w-full px-4 py-2 border rounded-lg">
                            </div>

                            <!-- Sort Select -->
                            <div class="flex gap-2">
                                <select name="sort" class="px-4 py-2 border rounded-lg">
                                    <option value="kode_barang" {{ request('sort') == 'kode_barang' ? 'selected' : '' }}>Kode Barang</option>
                                    <option value="nama_barang" {{ request('sort') == 'nama_barang' ? 'selected' : '' }}>Nama Barang</option>
                                    <option value="stok" {{ request('sort') == 'stok' ? 'selected' : '' }}>Stok</option>
                                    <option value="harga_satuan" {{ request('sort') == 'harga_satuan' ? 'selected' : '' }}>Harga</option>
                                </select>

                                <select name="direction" class="px-4 py-2 border rounded-lg">
                                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending ↑</option>
                                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending ↓</option>
                                </select>

                                <button type="submit" 
                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode Barang
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Satuan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga Satuan
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->kode_barang }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->nama_barang }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->stok }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->satuan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->lokasi_penyimpanan }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('inventory.edit', $item->id) }}" 
                                               class="text-blue-600 hover:text-blue-900 mr-3">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('inventory.destroy', $item->id) }}" 
                                                  method="POST" 
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            Tidak ada data barang
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $items->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when sort or direction changes
    const form = document.querySelector('form');
    const selects = form.querySelectorAll('select');
    
    selects.forEach(select => {
        select.addEventListener('change', () => {
            form.submit();
        });
    });
});
</script>
@endpush 
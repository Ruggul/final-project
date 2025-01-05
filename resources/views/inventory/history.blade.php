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
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-list mr-3"></i>Stock List
                    </a>
                    <a href="{{ route('inventory.create') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-plus mr-3"></i>Add Item
                    </a>
                    <a href="{{ route('inventory.history') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600 bg-gray-600">
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
                    <a href="{{ route('documents.history') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-history mr-3"></i>Document History
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
                <h2 class="text-xl font-semibold">Stock History</h2>
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
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <!-- ... rest of the history content ... -->
                </div>
            </div>
        </main>
    </div>
</div>
@endsection 
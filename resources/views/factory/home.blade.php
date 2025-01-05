@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed w-64 h-full bg-gray-800">
        <div class="flex items-center justify-center h-20 shadow-md">
            <h1 class="text-3xl uppercase text-white">Factory</h1>
        </div>

        <nav class="py-5">
            <!-- Factory Account Menu -->
            <div x-data="{ open: false }">
                <button @click="open = !open" 
                        class="w-full flex items-center justify-between text-gray-100 px-6 py-3 hover:bg-gray-700">
                    <span class="flex items-center">
                        <i class="fas fa-users mr-3"></i>
                        Factory Account
                    </span>
                    <i class="fas" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
                </button>
                <div x-show="open" class="bg-gray-700">
                    <a href="{{ route('factoryUser.index') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-list mr-3"></i>List Users
                    </a>
                    <a href="{{ route('factoryUser.create') }}" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-plus mr-3"></i>Add User
                    </a>
                </div>
            </div>

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
                    <a href="#inventory-list" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-list mr-3"></i>Stock List
                    </a>
                    <a href="#stock-movement" 
                       class="flex items-center text-gray-100 px-8 py-2 hover:bg-gray-600">
                        <i class="fas fa-exchange-alt mr-3"></i>Stock Movement
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64 flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-md py-4 px-6">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold">Factory Dashboard</h2>
                <div class="flex items-center space-x-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=Admin' }}" 
                                 class="h-8 w-8 rounded-full">
                            <span>{{ Auth::user()->name }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <div class="container mx-auto px-6 py-8">
                @livewire('factory-dashboard')
            </div>
        </main>
    </div>
</div>
@endsection
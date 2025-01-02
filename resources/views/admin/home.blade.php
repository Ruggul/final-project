<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 h-screen bg-gray-800 fixed">
            <div class="flex items-center justify-center h-20 shadow-md">
                <h1 class="text-white text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-5">
                <a href="#" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
                    <i class="fas fa-home mr-3"></i>
                    Overview
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
                    <i class="fas fa-users mr-3"></i>
                    Daftar User
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
                    <i class="fas fa-box mr-3"></i>
                    Daftar Produk
                </a>
                <a href="#" class="flex items-center py-3 px-6 text-white hover:bg-gray-700 transition">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Statistika
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex-1">
            <!-- Top Navigation -->
            <header class="bg-white h-20 shadow-md flex items-center justify-between px-6">
                <div class="flex items-center">
                    <span class="text-xl font-semibold">Dashboard</span>
                </div>
                <div class="flex items-center">
                    <div class="relative">
                        <button class="flex items-center text-gray-700 hover:text-gray-900">
                            <span class="mr-2">Admin</span>
                            <i class="fas fa-user-circle text-2xl"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-75">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600">Total Users</h2>
                                <p class="text-2xl font-semibold">1,250</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-75">
                                <i class="fas fa-box text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600">Total Produk</h2>
                                <p class="text-2xl font-semibold">150</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-75">
                                <i class="fas fa-shopping-cart text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600">Total Orders</h2>
                                <p class="text-2xl font-semibold">450</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-75">
                                <i class="fas fa-dollar-sign text-white text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-gray-600">Revenue</h2>
                                <p class="text-2xl font-semibold">$15,250</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Aktivitas Terbaru</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-3 text-left">User</th>
                                    <th class="px-6 py-3 text-left">Aktivitas</th>
                                    <th class="px-6 py-3 text-left">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-6 py-4">John Doe</td>
                                    <td class="px-6 py-4">Membeli Produk A</td>
                                    <td class="px-6 py-4">2 menit yang lalu</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-6 py-4">Jane Smith</td>
                                    <td class="px-6 py-4">Mendaftar sebagai user baru</td>
                                    <td class="px-6 py-4">5 menit yang lalu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>

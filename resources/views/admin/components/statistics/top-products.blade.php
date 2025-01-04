<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Laporan Produk Terlaris</h2>
        <div class="flex space-x-2">
            <!-- Filter Periode -->
            <select id="periodFilter" class="border rounded px-3 py-1">
                <option value="7">7 Hari Terakhir</option>
                <option value="30">30 Hari Terakhir</option>
                <option value="90">90 Hari Terakhir</option>
                <option value="custom">Periode Kustom</option>
            </select>
            <!-- Custom Date Range -->
            <div id="customDateRange" class="hidden flex space-x-2">
                <input type="date" id="topProductStartDate" class="border rounded px-3 py-1">
                <input type="date" id="topProductEndDate" class="border rounded px-3 py-1">
            </div>
            <a href="#" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Filter
            </a>
            <a href="#" class="bg-green-500 text-white px-4 py-1 rounded hover:bg-green-600">
                Export
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Penjualan Produk -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Penjualan Produk</p>
                    <h3 class="text-xl font-bold">1,234</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <h3 class="text-xl font-bold">Rp 45,678,000</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-money-bill text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Rata-rata Penjualan -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Rata-rata Penjualan/Hari</p>
                    <h3 class="text-xl font-bold">41.13</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-purple-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-6 py-3 text-left">Peringkat</th>
                    <th class="px-6 py-3 text-left">Kode Barang</th>
                    <th class="px-6 py-3 text-left">Nama Produk</th>
                    <th class="px-6 py-3 text-left">Total Terjual</th>
                    <th class="px-6 py-3 text-left">Total Pendapatan</th>
                    <th class="px-6 py-3 text-left">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Data -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">1</td>
                    <td class="px-6 py-4">PRD001</td>
                    <td class="px-6 py-4">Laptop Asus ROG</td>
                    <td class="px-6 py-4">50</td>
                    <td class="px-6 py-4">Rp 750,000,000</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 85%"></div>
                            </div>
                            <span class="ml-2">85%</span>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">2</td>
                    <td class="px-6 py-4">PRD002</td>
                    <td class="px-6 py-4">Monitor Gaming</td>
                    <td class="px-6 py-4">45</td>
                    <td class="px-6 py-4">Rp 225,000,000</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 65%"></div>
                            </div>
                            <span class="ml-2">65%</span>
                        </div>
                    </td>
                </tr>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">3</td>
                    <td class="px-6 py-4">PRD003</td>
                    <td class="px-6 py-4">Keyboard Mechanical</td>
                    <td class="px-6 py-4">30</td>
                    <td class="px-6 py-4">Rp 45,000,000</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                            </div>
                            <span class="ml-2">45%</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const periodFilter = document.getElementById('periodFilter');
    const customDateRange = document.getElementById('customDateRange');

    periodFilter.addEventListener('change', function() {
        if (this.value === 'custom') {
            customDateRange.classList.remove('hidden');
        } else {
            customDateRange.classList.add('hidden');
        }
    });
});
</script> 
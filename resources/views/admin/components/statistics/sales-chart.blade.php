<div class="bg-white rounded-lg shadow-md p-6">
    <!-- Header dan Filter -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Grafik Penjualan</h2>
        <div class="flex space-x-2">
            <select id="chartType" class="border rounded px-3 py-1">
                <option value="daily">Harian</option>
                <option value="weekly">Mingguan</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
            </select>
            <select id="chartView" class="border rounded px-3 py-1">
                <option value="bar">Bar Chart</option>
                <option value="line">Line Chart</option>
                <option value="area">Area Chart</option>
            </select>
            <div class="flex space-x-2">
                <input type="date" id="startDate" class="border rounded px-3 py-1">
                <input type="date" id="endDate" class="border rounded px-3 py-1">
            </div>
            <a href="#" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">
                Filter
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <!-- Total Penjualan -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Penjualan</p>
                    <h3 class="text-xl font-bold">Rp 12,345,678</h3>
                    <p class="text-xs text-green-500">+15% dari periode sebelumnya</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-chart-line text-blue-600"></i>
                </div>
            </div>
        </div>

        <!-- Rata-rata Penjualan -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Rata-rata Penjualan</p>
                    <h3 class="text-xl font-bold">Rp 411,523</h3>
                    <p class="text-xs text-green-500">+8% dari periode sebelumnya</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-calculator text-green-600"></i>
                </div>
            </div>
        </div>

        <!-- Penjualan Tertinggi -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Penjualan Tertinggi</p>
                    <h3 class="text-xl font-bold">Rp 892,000</h3>
                    <p class="text-xs text-gray-500">Pada 15 Nov 2023</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-arrow-up text-yellow-600"></i>
                </div>
            </div>
        </div>

        <!-- Penjualan Terendah -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Penjualan Terendah</p>
                    <h3 class="text-xl font-bold">Rp 156,000</h3>
                    <p class="text-xs text-gray-500">Pada 2 Nov 2023</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <i class="fas fa-arrow-down text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chart -->
    <div class="bg-white rounded-lg shadow p-4">
        <canvas id="salesChart" class="w-full" style="height: 400px;"></canvas>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sample data untuk demo
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Penjualan 2023',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 60, 75, 85, 90],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
});
</script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> 
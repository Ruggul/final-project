<div class="overflow-x-auto">
    <table class="min-w-full table-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-6 py-3 text-left">Kode Barang</th>
                <th class="px-6 py-3 text-left">Nama Barang</th>
                <th class="px-6 py-3 text-left">Deskripsi</th>
                <th class="px-6 py-3 text-left">Stok</th>
                <th class="px-6 py-3 text-left">Satuan</th>
                <th class="px-6 py-3 text-left">Harga Satuan</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody id="productsTableBody">
            <!-- Data will be populated by JavaScript -->
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto">
    <div class="relative p-8 bg-white max-w-md mx-auto my-10 rounded-lg" style="margin-bottom: 100px;">
        <h2 class="text-xl font-bold mb-4">Edit Produk</h2>
        <form id="editForm">
            <input type="hidden" id="editProductId">
            <div class="mb-4">
                <label class="block mb-2">Kode Barang</label>
                <input type="text" id="editKodeBarang" class="w-full border rounded px-3 py-2" readonly>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Nama Barang</label>
                <input type="text" id="editNamaBarang" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block mb-2">Deskripsi</label>
                <textarea id="editDeskripsi" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <div class="mb-4">
                <label class="block mb-2">Stok</label>
                <input type="number" id="editStok" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block mb-2">Satuan</label>
                <input type="text" id="editSatuan" class="w-full border rounded px-3 py-2">
            </div>
            <div class="mb-4">
                <label class="block mb-2">Harga Satuan</label>
                <input type="number" step="0.01" id="editHargaSatuan" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</div> 
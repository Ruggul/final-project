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
            @if(isset($items))
                @foreach($items as $product)
                    <tr class="border-b hover:bg-gray-50" data-product-id="{{ $product->id }}">
                        <td class="px-6 py-4">{{ $product->kode_barang }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-medium">{{ $product->nama_barang }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">{{ $product->deskripsi }}</td>
                        <td class="px-6 py-4">{{ $product->stok }}</td>
                        <td class="px-6 py-4">{{ $product->satuan }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($product->harga_satuan) }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <span class="mr-2">{{ $product->lokasi }}</span>
                                <button onclick="openEditModal({
                                    id: '{{ $product->id }}',
                                    kode_barang: '{{ $product->kode_barang }}',
                                    nama_barang: '{{ $product->nama_barang }}',
                                    deskripsi: '{{ $product->deskripsi }}',
                                    stok: '{{ $product->stok }}',
                                    satuan: '{{ $product->satuan }}',
                                    harga_satuan: '{{ $product->harga_satuan }}',
                                    lokasi: '{{ $product->lokasi }}'
                                })" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                    Edit
                                </button>
                                <button onclick="deleteProduct('{{ $product->id }}')" 
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center">Tidak ada data produk</td>
                </tr>
            @endif
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
            <div class="mb-4">
                <label class="block mb-2">Lokasi</label>
                <input type="text" id="editLokasi" class="w-full border rounded px-3 py-2">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>
</div> 

<script>
function openEditModal(product) {
    // Populate modal with product data
    document.getElementById('editProductId').value = product.id;
    document.getElementById('editKodeBarang').value = product.kode_barang;
    document.getElementById('editNamaBarang').value = product.nama_barang;
    document.getElementById('editDeskripsi').value = product.deskripsi;
    document.getElementById('editStok').value = product.stok;
    document.getElementById('editSatuan').value = product.satuan;
    document.getElementById('editHargaSatuan').value = product.harga_satuan;
    document.getElementById('editLokasi').value = product.lokasi;
    
    // Show modal
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Handle form submission for editing
document.getElementById('editForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const productId = document.getElementById('editProductId').value;
    const formData = {
        kode_barang: document.getElementById('editKodeBarang').value,
        nama_barang: document.getElementById('editNamaBarang').value,
        deskripsi: document.getElementById('editDeskripsi').value,
        stok: document.getElementById('editStok').value,
        satuan: document.getElementById('editSatuan').value,
        harga_satuan: document.getElementById('editHargaSatuan').value,
        lokasi: document.getElementById('editLokasi').value
    };

    try {
        const response = await fetch(`/api/products/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        if (response.ok) {
            alert('Produk berhasil diperbarui');
            closeEditModal();
            location.reload(); // Reload to show updated data
        } else {
            const error = await response.json();
            alert('Error: ' + error.message);
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
});

// Update the table row to include edit button
function updateTableRows() {
    const rows = document.querySelectorAll('#productsTableBody tr');
    rows.forEach(row => {
        const product = {
            id: row.dataset.productId,
            kode_barang: row.querySelector('td:nth-child(1)').textContent,
            nama_barang: row.querySelector('td:nth-child(2)').textContent,
            deskripsi: row.querySelector('td:nth-child(3)').textContent,
            stok: row.querySelector('td:nth-child(4)').textContent,
            satuan: row.querySelector('td:nth-child(5)').textContent,
            harga_satuan: row.querySelector('td:nth-child(6)').textContent.replace('Rp ', '').replace(',', ''),
            lokasi: row.querySelector('td:nth-child(7)').textContent
        };

        const editButton = row.querySelector('.bg-blue-500');
        editButton.addEventListener('click', (e) => {
            e.preventDefault();
            openEditModal(product);
        });
    });
}

// Handle delete
async function deleteProduct(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        return;
    }

    try {
        const response = await fetch(`/api/products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (response.ok) {
            alert('Produk berhasil dihapus');
            location.reload(); // Reload to update the table
        } else {
            const error = await response.json();
            alert('Error: ' + error.message);
        }
    } catch (error) {
        alert('Error: ' + error.message);
    }
}

// Initialize when document loads
document.addEventListener('DOMContentLoaded', function() {
    updateTableRows();
});
</script> 
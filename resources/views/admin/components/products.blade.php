<div id="products-content" class="hidden">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Daftar Produk</h2>
            <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Tambah Produk
            </button>
        </div>
        @include('admin.components.products.table')
    </div>
</div> 
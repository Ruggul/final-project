<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        Item::create([
            'kode_barang' => 'BB001',
            'nama_barang' => 'Kain Cotton',
            'stok' => 100,
            'satuan' => 'meter',
            'harga_satuan' => 50000,
            'category_id' => 1, // Bahan Baku
        ]);

        Item::create([
            'kode_barang' => 'BJ001',
            'nama_barang' => 'Kemeja Lengan Pendek',
            'stok' => 50,
            'satuan' => 'pcs',
            'harga_satuan' => 150000,
            'category_id' => 2, // Barang Jadi
        ]);

        Item::create([
            'kode_barang' => 'PR001',
            'nama_barang' => 'Mesin Jahit',
            'stok' => 5,
            'satuan' => 'unit',
            'harga_satuan' => 2000000,
            'category_id' => 3, // Peralatan
        ]);

        Item::create([
            'kode_barang' => 'PK001',
            'nama_barang' => 'Plastik Packaging',
            'stok' => 1000,
            'satuan' => 'pcs',
            'harga_satuan' => 1000,
            'category_id' => 4, // Packaging
        ]);

        Item::create([
            'kode_barang' => 'SP001',
            'nama_barang' => 'Jarum Mesin Jahit',
            'stok' => 100,
            'satuan' => 'pcs',
            'harga_satuan' => 5000,
            'category_id' => 5, // Sparepart
        ]);
    }
}

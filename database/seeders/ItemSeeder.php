<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // Bahan Baku (category_id: 1)
        Item::create([
            'kode_barang' => 'BB001',
            'nama_barang' => 'Besi Hollow 4x4',
            'stok' => 150,
            'satuan' => 'batang',
            'harga_satuan' => 75000,
            'category_id' => 1,
        ]);

        Item::create([
            'kode_barang' => 'BB002',
            'nama_barang' => 'Plat Besi 2mm',
            'stok' => 80,
            'satuan' => 'lembar',
            'harga_satuan' => 450000,
            'category_id' => 1,
        ]);

        Item::create([
            'kode_barang' => 'BB003',
            'nama_barang' => 'Kayu Meranti 6x12',
            'stok' => 100,
            'satuan' => 'batang',
            'harga_satuan' => 125000,
            'category_id' => 1,
        ]);

        Item::create([
            'kode_barang' => 'BB004',
            'nama_barang' => 'Pipa PVC 4 inch',
            'stok' => 200,
            'satuan' => 'batang',
            'harga_satuan' => 85000,
            'category_id' => 1,
        ]);

        Item::create([
            'kode_barang' => 'BB005',
            'nama_barang' => 'Aluminium Profil',
            'stok' => 120,
            'satuan' => 'batang',
            'harga_satuan' => 95000,
            'category_id' => 1,
        ]);

        // Peralatan (category_id: 2)
        Item::create([
            'kode_barang' => 'PR001',
            'nama_barang' => 'Mesin Las Listrik',
            'stok' => 5,
            'satuan' => 'unit',
            'harga_satuan' => 2500000,
            'category_id' => 2,
        ]);

        Item::create([
            'kode_barang' => 'PR002',
            'nama_barang' => 'Gerinda Tangan',
            'stok' => 8,
            'satuan' => 'unit',
            'harga_satuan' => 850000,
            'category_id' => 2,
        ]);

        // Bahan Pendukung (category_id: 3)
        Item::create([
            'kode_barang' => 'BP001',
            'nama_barang' => 'Elektroda Las 2.6mm',
            'stok' => 500,
            'satuan' => 'kg',
            'harga_satuan' => 45000,
            'category_id' => 3,
        ]);

        Item::create([
            'kode_barang' => 'BP002',
            'nama_barang' => 'Mata Gerinda Potong 4"',
            'stok' => 300,
            'satuan' => 'pcs',
            'harga_satuan' => 12000,
            'category_id' => 3,
        ]);

        Item::create([
            'kode_barang' => 'BP003',
            'nama_barang' => 'Cat Besi Primer',
            'stok' => 50,
            'satuan' => 'kaleng',
            'harga_satuan' => 85000,
            'category_id' => 3,
        ]);

        // Sparepart (category_id: 4)
        Item::create([
            'kode_barang' => 'SP001',
            'nama_barang' => 'Bearing 6201',
            'stok' => 100,
            'satuan' => 'pcs',
            'harga_satuan' => 35000,
            'category_id' => 4,
        ]);

        Item::create([
            'kode_barang' => 'SP002',
            'nama_barang' => 'V-Belt A34',
            'stok' => 45,
            'satuan' => 'pcs',
            'harga_satuan' => 42000,
            'category_id' => 4,
        ]);

        // Safety Equipment (category_id: 5)
        Item::create([
            'kode_barang' => 'SF001',
            'nama_barang' => 'Sarung Tangan Las',
            'stok' => 30,
            'satuan' => 'pasang',
            'harga_satuan' => 75000,
            'category_id' => 5,
        ]);

        Item::create([
            'kode_barang' => 'SF002',
            'nama_barang' => 'Kacamata Safety',
            'stok' => 25,
            'satuan' => 'pcs',
            'harga_satuan' => 45000,
            'category_id' => 5,
        ]);

        Item::create([
            'kode_barang' => 'SF003',
            'nama_barang' => 'Masker Las',
            'stok' => 15,
            'satuan' => 'pcs',
            'harga_satuan' => 225000,
            'category_id' => 5,
        ]);
    }
}


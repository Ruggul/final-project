<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run()
    {
        // Bahan Baku
        for ($i = 1; $i <= 20; $i++) {
            Item::create([
                'kode_barang' => 'BB' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => 'Besi Hollow ' . rand(2, 8) . 'x' . rand(2, 8),
                'deskripsi' => 'Besi hollow galvanis ukuran standar, panjang 6 meter',
                'stok' => rand(50, 200),
                'satuan' => 'batang',
                'harga_satuan' => rand(50, 150) * 1000,
                'lokasi_penyimpanan' => 'Gudang A-' . rand(1, 5),
            ]);
        }

        // Peralatan
        for ($i = 1; $i <= 10; $i++) {
            Item::create([
                'kode_barang' => 'PR' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => 'Mesin ' . ['Las', 'Gerinda', 'Bor', 'Potong', 'Bubut'][rand(0, 4)],
                'deskripsi' => 'Peralatan standar industri',
                'stok' => rand(2, 10),
                'satuan' => 'unit',
                'harga_satuan' => rand(500, 5000) * 1000,
                'lokasi_penyimpanan' => 'Ruang Alat-' . rand(1, 3),
            ]);
        }

        // Bahan Pendukung
        for ($i = 1; $i <= 10; $i++) {
            Item::create([
                'kode_barang' => 'BP' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => ['Cat Besi', 'Elektroda', 'Mata Bor', 'Mata Gerinda', 'Amplas'][rand(0, 4)],
                'deskripsi' => 'Bahan pendukung produksi',
                'stok' => rand(100, 1000),
                'satuan' => ['box', 'kg', 'pcs', 'roll', 'lembar'][rand(0, 4)],
                'harga_satuan' => rand(10, 100) * 1000,
                'lokasi_penyimpanan' => 'Rak-' . chr(rand(65, 70)) . rand(1, 5),
            ]);
        }

        // Safety Equipment
        for ($i = 1; $i <= 10; $i++) {
            Item::create([
                'kode_barang' => 'SF' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_barang' => ['Sarung Tangan', 'Kacamata', 'Masker', 'Sepatu Safety', 'Helm'][rand(0, 4)],
                'deskripsi' => 'Peralatan keselamatan kerja',
                'stok' => rand(20, 100),
                'satuan' => ['pasang', 'pcs', 'unit', 'set'][rand(0, 3)],
                'harga_satuan' => rand(50, 500) * 1000,
                'lokasi_penyimpanan' => 'Lemari APD-' . rand(1, 3),
            ]);
        }
    }
}


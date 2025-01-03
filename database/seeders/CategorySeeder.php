<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Bahan Baku']);
        Category::create(['name' => 'Barang Jadi']);
        Category::create(['name' => 'Peralatan']);
        Category::create(['name' => 'Packaging']);
        Category::create(['name' => 'Sparepart']);
    }
}

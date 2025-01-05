<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'satuan',
        'harga_satuan',
        'lokasi_penyimpanan',
        'deskripsi'
    ];
} 
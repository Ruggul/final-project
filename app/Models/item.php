<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'stok',
        'satuan',
        'harga_satuan',
        'lokasi_penyimpanan'
    ];
}

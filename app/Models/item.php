<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'stok',
        'satuan',
        'harga_satuan',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

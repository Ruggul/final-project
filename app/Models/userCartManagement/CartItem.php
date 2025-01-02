<?php

namespace App\Models\userCartManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'item_keranjang'; // Nama tabel
    protected $fillable = ['id_keranjang', 'id_produk', 'jumlah'];

    // Relasi ke Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_keranjang');
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk');
    }
}
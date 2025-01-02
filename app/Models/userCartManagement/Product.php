<?php

namespace App\Models\userCartManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk'; // Nama tabel
    protected $fillable = ['nama', 'deskripsi', 'harga', 'stok'];

    // Relasi ke CartItem
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_produk');
    }
}

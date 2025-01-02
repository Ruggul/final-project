<?php

namespace App\Models\userCartManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'keranjang'; // Nama tabel
    protected $fillable = ['id_pengguna'];

    public function items()
    {
        return $this->hasMany(CartItem::class, 'id_keranjang');
    }
}

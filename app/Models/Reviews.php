<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    //Atribut yang dapat diisi secara massal
    protected $fillable = [
        'product_id',
        'order_id',
        'rating',
        'review_text',
        'review_images',
        'purchase_date'
    ];

    //Atribut yang harus dikonversi ke tipe data tertentu
    protected $casts = [
        'rating' => 'integer',
        'review_images' => 'array',
        'purchase_date' => 'datetime'
    ];

    //Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    //Scope untuk filter berdasarkan rating
    public function scopeByRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }
}
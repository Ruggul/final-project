<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'payment_details',
        'status'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'amount' => 'decimal:2'
    ];

    // Konstanta untuk status pembayaran
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';

    // Konstanta untuk metode pembayaran
    const METHOD_BANK = 'bank_transfer';
    const METHOD_QRIS = 'qris';
    const METHOD_EWALLET = 'e_wallet';

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke User (melalui Order)
    public function user()
    {
        return $this->hasOneThrough(User::class, Order::class);
    }
} 
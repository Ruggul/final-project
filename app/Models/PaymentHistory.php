<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $table = 'payment_history';

    protected $fillable = [
        'factory_id',
        'invoice_number',
        'amount',
        'payment_status',
        'payment_method',
        'payment_date',
        'due_date',
        'description'
    ];


    protected $casts = [
        'payment_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    //Status pembayaran yang tersedia
    const PAYMENT_STATUS = [
        'PENDING' => 'pending',
        'PAID' => 'paid',
        'FAILED' => 'failed',
        'REFUNDED' => 'refunded'
    ];

    //Metode pembayaran yang tersedia
    const PAYMENT_METHODS = [
        'CREDIT_CARD' => 'credit_card',
        'BANK_TRANSFER' => 'bank_transfer',
        'E_WALLET' => 'e-wallet',
        'OTHER' => 'other'
    ];

    //Relasi ke model Factory
    public function factory(): BelongsTo
    {
        return $this->belongsTo(Factory::class);
    }

    //Scope untuk filter berdasarkan status pembayaran
    public function scopeByStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    //Scope untuk filter berdasarkan metode pembayaran
    public function scopeByPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    //Scope untuk filter pembayaran yang jatuh tempo
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('payment_status', self::PAYMENT_STATUS['PENDING']);
    }
}
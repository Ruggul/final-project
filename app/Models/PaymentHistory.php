<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
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

    // Konstanta untuk status pembayaran
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';
    const STATUS_REFUNDED = 'refunded';

    // Konstanta untuk metode pembayaran
    const METHOD_CREDIT_CARD = 'credit_card';
    const METHOD_BANK_TRANSFER = 'bank_transfer';
    const METHOD_E_WALLET = 'e-wallet';
    const METHOD_OTHER = 'other';

    // Scope untuk filter berdasarkan status
    public function scopeStatus($query, $status)
    {
        return $query->where('payment_status', $status);
    }

    // Scope untuk filter berdasarkan metode pembayaran
    public function scopePaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    // Scope untuk pembayaran yang jatuh tempo
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::now())
                    ->where('payment_status', self::STATUS_PENDING);
    }

    // Accessor untuk format amount dengan currency
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 2, ',', '.');
    }

    // Method untuk cek status pembayaran
    public function isPaid()
    {
        return $this->payment_status === self::STATUS_PAID;
    }

    public function isPending()
    {
        return $this->payment_status === self::STATUS_PENDING;
    }

    public function isOverdue()
    {
        return $this->due_date < Carbon::now() && $this->payment_status === self::STATUS_PENDING;
    }

    // Method untuk update status pembayaran
    public function markAsPaid()
    {
        $this->update([
            'payment_status' => self::STATUS_PAID,
            'payment_date' => Carbon::now()
        ]);
    }
}
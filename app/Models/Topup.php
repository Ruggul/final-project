<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Topup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'transaction_number',
        'amount',
        'payment_method',
        'status',
        'payment_date'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2'
    ];

    /**
     * Payment method constants
     */
    const PAYMENT_BANK_TRANSFER = 'bank_transfer';
    const PAYMENT_E_WALLET = 'e-wallet';

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';

    /**
     * Get the user that owns the topup
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
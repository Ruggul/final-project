<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    //Nama tabel yang digunakan oleh model
    protected $table = 'payment_method';

    //Atribut yang dapat diisi secara massal
    protected $fillable = [
        'payment_type',
        'account_name',
        'account_number',
        'bank_name',
        'card_type',
        'expiry_date'
    ];

    //Atribut yang harus dikonversi ke tipe data tertentu
    protected $casts = [
        'expiry_date' => 'string',
    ];

    //Scope untuk mencari berdasarkan tipe pembayaran
    public function scopeByPaymentType($query, $type)
    {
        return $query->where('payment_type', $type);
    }

    //Scope untuk mencari berdasarkan tipe kartu
    public function scopeByCardType($query, $type)
    {
        return $query->where('card_type', $type);
    }

    //Scope untuk mencari berdasarkan nama bank
    public function scopeByBankName($query, $name)
    {
        return $query->where('bank_name', $name);
    }

    //Cek apakah metode pembayaran adalah kartu kredit
    public function isCreditCard()
    {
        return $this->payment_type === 'credit_card';
    }

    //Cek apakah metode pembayaran adalah rekening bank
    public function isBankAccount()
    {
        return $this->payment_type === 'bank_account';
    }

    //Cek apakah metode pembayaran adalah e-wallet
    public function isEWallet()
    {
        return $this->payment_type === 'e-wallet';
    }
}
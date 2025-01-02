<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Account extends Authenticatable
{
    use HasFactory, Notifiable;

    //Nama tabel yang digunakan oleh model
    protected $table = 'account';

    //Atribut yang dapat diisi secara massal
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address',
        'password'
    ];

    //Atribut yang harus disembunyikan
    protected $hidden = [
        'password',
    ];

    //Atribut yang harus dikonversi ke tipe data tertentu
    protected $casts = [
        'password' => 'hashed',
    ];

    //Relasi ke PaymentMethod
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    //Relasi ke Document
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    //Scope untuk mencari berdasarkan email
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    //Scope untuk mencari berdasarkan username
    public function scopeByUsername($query, $username)
    {
        return $query->where('username', $username);
    }
}
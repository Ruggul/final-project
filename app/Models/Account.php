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

    //Mengenkripsi password sebelum disimpan
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
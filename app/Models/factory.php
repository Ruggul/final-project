<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Factory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'factory';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email'
    ];

    // Validasi rules
    public static $rules = [
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'phone' => 'required|string|max:20',
        'email' => 'required|email|unique:factory,email'
    ];

    // Scope untuk pencarian
    public function scopeSearch(Builder $query, $keyword)
    {
        return $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%");
    }

    // Accessor untuk format nomor telepon
    public function getPhoneNumberAttribute()
    {
        return '+' . $this->phone;
    }

    // Mutator untuk email (memastikan email dalam lowercase)
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    // Method untuk mengecek apakah factory aktif
    public function isActive()
    {
        return $this->deleted_at === null;
    }
}
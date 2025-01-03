<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    //Atribut yang dapat diisi secara massal
    protected $fillable = [
        'document_type',
        'document_name',
        'file_path',
        'expiry_date'
    ];

    //Atribut yang harus dikonversi ke tipe data tertentu
    protected $casts = [
        'expiry_date' => 'date'
    ];

    //Scope untuk mencari dokumen berdasarkan tipe
    public function scopeByType($query, $type)
    {
        return $query->where('document_type', $type);
    }

    //Mendapatkan URL lengkap file
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
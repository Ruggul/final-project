<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    //Atribut yang dapat diisi secara massal
    protected $fillable = [
        'document_type',
        'document_name',
        'file_path',
        'expiry_date',
        'published_at',
        'reviewed_at',
        'approved_at'
    ];

    //Atribut yang harus dikonversi ke tipe data tertentu
    protected $casts = [
        'expiry_date' => 'date',
        'published_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
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
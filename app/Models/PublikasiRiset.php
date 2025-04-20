<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublikasiRiset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publikasi_riset';

    protected $fillable = [
        'judul',
        'penulis',
        'deskripsi',
        'gambar_path',
        'gambar_nama',
        'file_path',
        'file_nama',
        'kategori',
        'tanggal_publikasi'
    ];

    protected $dates = [
        'tanggal_publikasi',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
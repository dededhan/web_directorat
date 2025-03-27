<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'tanggal_publikasi',
        'judul_dokumen',
        'deskripsi',
        'nama_file',
        'nama_file_hash',
        'path',
        'pdf_preview_path', // Added for storing PDF conversion path
        'ukuran',
        'ekstensi'
    ];
}
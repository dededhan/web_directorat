<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniBerdampak extends Model
{
    use HasFactory;

    protected $table = 'alumni_berdampak';

    protected $fillable = [
        'judul_berita',
        'tanggal_berita',
        'fakultas',
        'prodi',
        'link_berita'
    ];
}
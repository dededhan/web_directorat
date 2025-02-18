<?php
// File: app/Models/Akreditasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akreditasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'fakultas',
        'prodi', 
        'lembaga_akreditasi',
        'peringkat',
        'nomor_sk',
        'periode_awal',
        'periode_akhir'
    ];
}
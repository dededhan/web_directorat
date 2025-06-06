<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pimpinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jabatan',
        'deskripsi',
        'gambar'
    ];
}
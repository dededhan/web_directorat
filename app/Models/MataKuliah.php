<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_matkul',
        'semester',
        'kode_matkul',
        'fakultas',
        'prodi',
        'rps_path',
        'deskripsi'
    ];
}
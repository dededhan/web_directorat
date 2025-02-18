<?php
// app/Models/DosenInternasional.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenInternasional extends Model
{
    use HasFactory;

    protected $fillable = [
        'fakultas',
        'prodi',
        'nama', 
        'negara',
        'universitas_asal',
        'status',
        'bidang_keahlian'
    ];
}
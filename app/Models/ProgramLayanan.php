<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'judul', 
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
}
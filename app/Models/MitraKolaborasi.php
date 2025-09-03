<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MitraKolaborasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'link_website',
        'kategori',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumumans'; // Ta
    // app/Models/Pengumuman.php
protected $fillable = [
    'judul_pengumuman', 
    'icon', 
    'isi_pengumuman', 
    'status'
];
}

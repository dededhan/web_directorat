<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mahasiswa',
        'nim',
        'negara',
        'kategori',
        'status',
        'fakultas',
        'program_studi',
        'periode_mulai',
        'periode_akhir'
    ];
}
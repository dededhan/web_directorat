<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AktivitasDosenAsing extends Model
{
    use HasFactory;
    
    protected $table = 'aktivitas_dosen_asing';

    protected $fillable = [
        'tanggal',
        'judul',
        'isi',
        'gambar'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentingSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'status',
    ];

    // Satu Sesi punya BANYAK Laporan
    public function reports()
    {
        return $this->hasMany(PresentingReport::class);
    }
}
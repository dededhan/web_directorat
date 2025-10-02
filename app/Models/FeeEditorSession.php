<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeEditorSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'status',
    ];

    // Relasi: Satu Sesi Editor punya BANYAK Laporan Editor
    public function reports()
    {
        return $this->hasMany(FeeEditorReport::class);
    }
}
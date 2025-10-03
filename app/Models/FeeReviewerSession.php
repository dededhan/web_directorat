<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeReviewerSession extends Model
{
    use HasFactory;

    // Tentukan kolom mana saja yang boleh diisi secara massal
    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'status',
    ];

    // Definisikan relasi: Satu Sesi punya BANYAK Laporan
    public function reports()
    {
        return $this->hasMany(FeeReviewerReport::class);
    }

    public function getComputedStatusAttribute()
    {
        $now = \Carbon\Carbon::now();
        $periodeAkhir = \Carbon\Carbon::parse($this->periode_akhir);

        if ($this->status === 'Tutup' || $now->gt($periodeAkhir)) {
            return 'Tutup';
        }

        return 'Buka';
    }
}
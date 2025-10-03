<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
    ];

    protected $appends = ['computed_status'];

    public function getComputedStatusAttribute()
    {
        $now = Carbon::now();
        $periodeAkhir = Carbon::parse($this->periode_akhir);
        
        if ($this->status === 'Tutup' || $now->gt($periodeAkhir)) {
            return 'Tutup';
        }
        
        return 'Buka';
    }

    // Satu Sesi punya BANYAK Laporan
    public function reports()
    {
        return $this->hasMany(PresentingReport::class);
    }
}
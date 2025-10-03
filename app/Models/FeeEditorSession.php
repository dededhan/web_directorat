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

    public function reports()
    {
        return $this->hasMany(FeeEditorReport::class);
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
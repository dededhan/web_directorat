<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class MatchmakingSession extends Model
{
    use HasFactory;


    protected $table = 'matchmaking_sessions';


    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'status',
    ];


    protected $casts = [
        'periode_awal' => 'datetime',
        'periode_akhir' => 'datetime',
    ];


    public function submissions()
    {
        return $this->hasMany(MatchmakingSubmission::class, 'matchmaking_session_id');
    }


    public function getComputedStatusAttribute(): string
    {
        if ($this->attributes['status'] === 'Tutup') {
            return 'Tutup';
        }

        $now = Carbon::now();
        if ($now->between($this->periode_awal, $this->periode_akhir->endOfDay())) {
            return 'Buka';
        }

        return 'Tutup';
    }
}

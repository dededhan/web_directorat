<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApcSession extends Model
{
    use HasFactory;

    protected $table = 'apc_sessions';

    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'dana',
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
        return $this->hasMany(ApcSubmission::class, 'apc_session_id');
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

    public static function syncSubmissionsForClosedSessions()
    {
        $closedSessionIds = self::where('status', 'Tutup')
                                ->orWhere('periode_akhir', '<', now()->startOfDay())
                                ->pluck('id');
        
        if ($closedSessionIds->isNotEmpty()) {
            $submissionsToUpdate = ApcSubmission::whereIn('apc_session_id', $closedSessionIds)
                                                ->where('status', 'diajukan')
                                                ->get();

            if($submissionsToUpdate->isNotEmpty()) {
                ApcSubmission::whereIn('id', $submissionsToUpdate->pluck('id'))->update(['status' => 'verifikasi']);

                foreach ($submissionsToUpdate as $submission) {

                    $submission->refresh(); 
                    $submission->addStatusLog('verifikasi', 'Status diubah otomatis oleh sistem karena sesi telah ditutup.');
                }
            }
        }
    }
}


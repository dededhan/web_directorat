<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ApcSubmission extends Model
{
    use HasFactory;

    protected $table = 'apc_submissions';

    protected $fillable = [
        'apc_session_id',
        'user_id',
        'nama_jurnal_q1',
        'link_scimagojr',
        'judul_artikel',
        'volume',
        'issue',
        'biaya_publikasi',
        'artikel_path',
        'invoice_path',
        'submission_process_path',
        'status',
        'status_history',
    ];


    protected $casts = [
        'status_history' => 'array',
    ];

    public function session()
    {
        return $this->belongsTo(ApcSession::class, 'apc_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authors()
    {
        return $this->hasMany(ApcAuthor::class, 'apc_submission_id');
    }


    public function addStatusLog(string $newStatus, ?string $notes = null): void
    {
        $history = $this->status_history ?? [];
        
        $logEntry = [
            'status' => $newStatus,
            'timestamp' => Carbon::now()->toIso8601String(),
            'notes' => $notes,
        ];

        $history[] = $logEntry;

        $this->update(['status_history' => $history]);
    }
}

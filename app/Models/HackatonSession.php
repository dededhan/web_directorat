<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonSession extends Model
{
    use HasFactory;

    protected $table = 'hackaton_sessions';

    protected $guarded = ['id'];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'dana_minimal' => 'decimal:2',
        'dana_maksimal' => 'decimal:2',
    ];

    public function tahap()
    {
        return $this->hasMany(HackatonTahap::class, 'hackaton_session_id')
            ->orderBy('tahap_ke');
    }

    public function submissions()
    {
        return $this->hasMany(HackatonSubmission::class, 'hackaton_session_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

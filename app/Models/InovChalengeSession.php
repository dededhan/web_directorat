<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeSession extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'dana_maksimal' => 'decimal:2',
    ];

    public function tahap()
    {
        return $this->hasMany(InovChalengeTahap::class, 'inov_chalenge_session_id')
            ->orderBy('tahap_ke');
    }

    public function submissions()
    {
        return $this->hasMany(InovChalengeSubmission::class, 'inov_chalenge_session_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsentAttemptLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'email',
        'qs_session_id',
        'responden_bank_id',
        'token_used',
        'ip_address',
        'user_agent',
        'attempted_at',
        'result',
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
    ];

    /**
     * The session this attempt was for.
     */
    public function session()
    {
        return $this->belongsTo(QsSession::class, 'qs_session_id');
    }

    /**
     * The bank respondent this attempt relates to.
     */
    public function bankRespondent()
    {
        return $this->belongsTo(RespondenBank::class, 'responden_bank_id');
    }
}

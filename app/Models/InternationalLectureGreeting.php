<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalLectureGreeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'greeting_type',
        'subject',
        'message',
        'lecturer_id',
        'recipient_name',
        'recipient_email',
        'email_status',
        'email_sent_at',
        'email_error',
    ];

    protected $casts = [
        'email_sent_at' => 'datetime',
    ];

    public function lecturer()
    {
        return $this->belongsTo(DosenInternasional::class, 'lecturer_id');
    }
}

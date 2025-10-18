<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamSessionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_session_id',
        'activity_type',
        'metadata',
        'logged_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'logged_at' => 'datetime',
    ];

    public $timestamps = false;

    public function examSession(): BelongsTo
    {
        return $this->belongsTo(ExamSession::class);
    }
}

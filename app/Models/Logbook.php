<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logbook extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comdev_submission_id',
        'activity_date',
        'notes',
        'progress_percentage',
        'attachment_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activity_date' => 'date',
    ];

    /**
     * Mendapatkan submission (proposal) yang memiliki logbook ini.
     */
    public function comdevSubmission(): BelongsTo
    {
        return $this->belongsTo(ComdevSubmission::class, 'comdev_submission_id');
    }
}
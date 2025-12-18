<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidatorProgress extends Model
{
    use HasFactory;

    protected $table = 'validator_progress';

    protected $fillable = [
        'form_id',
        'validator_id',
        'agreement_completed',
        'assessment_completed',
        'berita_acara_completed',
        'record_completed',
        'all_completed',
        'started_at',
        'submitted_at',
        'status',
    ];

    protected $casts = [
        'agreement_completed' => 'boolean',
        'assessment_completed' => 'boolean',
        'berita_acara_completed' => 'boolean',
        'record_completed' => 'boolean',
        'all_completed' => 'boolean',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
    ];

    /**
     * Relasi ke Form
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Relasi ke Validator (User)
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }

    /**
     * Check apakah sudah dapat submit
     */
    public function canSubmit()
    {
        return $this->agreement_completed
            && $this->assessment_completed
            && $this->berita_acara_completed
            && $this->record_completed;
    }

    /**
     * Check apakah dalam status read-only
     */
    public function isReadOnly()
    {
        return $this->status === 'completed' && $this->all_completed;
    }
}

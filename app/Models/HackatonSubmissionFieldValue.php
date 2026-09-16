<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonSubmissionFieldValue extends Model
{
    use HasFactory;

    protected $table = 'hackaton_submission_field_values';

    protected $guarded = ['id'];

    public function submission()
    {
        return $this->belongsTo(HackatonSubmission::class, 'hackaton_submission_id');
    }

    public function tahap()
    {
        return $this->belongsTo(HackatonTahap::class, 'hackaton_tahap_id');
    }

    public function field()
    {
        return $this->belongsTo(HackatonTahapField::class, 'hackaton_tahap_field_id');
    }

    public function getValueTextAttribute(): ?string
    {
        return $this->attributes['value'] ?? null;
    }

    public function getValueFilePathAttribute(): ?string
    {
        return $this->attributes['value'] ?? null;
    }

    public function getValueUrlAttribute(): ?string
    {
        return $this->attributes['value'] ?? null;
    }

    public function getOriginalFilenameAttribute(): ?string
    {
        $val = $this->attributes['value'] ?? null;
        return $val ? basename($val) : null;
    }
}

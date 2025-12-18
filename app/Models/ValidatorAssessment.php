<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidatorAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'validator_id',
        'katsinov_category_id',
        'katsinov_indicator_id',
        'dosen_score',
        'validator_score',
        'bobot',
        'indicator_comment',
        'status',
    ];

    protected $casts = [
        'dosen_score' => 'decimal:2',
        'validator_score' => 'decimal:2',
        'bobot' => 'decimal:2',
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
     * Relasi ke KATSINOV Category
     */
    public function category()
    {
        return $this->belongsTo(KatsinovCategory::class, 'katsinov_category_id');
    }

    /**
     * Relasi ke KATSINOV Indicator
     */
    public function indicator()
    {
        return $this->belongsTo(KatsinovIndicator::class, 'katsinov_indicator_id');
    }

    /**
     * Hitung nilai tertimbang
     */
    public function getNilaiTertimbangAttribute()
    {
        if ($this->validator_score && $this->bobot) {
            return ($this->validator_score * $this->bobot) / 100;
        }
        return 0;
    }
}

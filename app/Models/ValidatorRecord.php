<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidatorRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'validator_id',
        'executive_summary',
        'strengths',
        'weaknesses',
        'opportunities',
        'threats',
        'improvement_suggestions',
        'implementation_recommendations',
        'final_notes',
        'status',
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
}

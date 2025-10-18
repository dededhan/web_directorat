<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_bank_id',
        'name',
        'description',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function questionBank(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}

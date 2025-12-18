<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidatorCategoryComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'validator_id',
        'katsinov_category_id',
        'comment',
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormFundingSource extends Model
{
    protected $fillable = [
        'innovator_form_id', 
        'tahun_ke',
        'total_dana',
        'sumber_dana'
    ];

    protected $casts = [
        'total_dana' => 'decimal:2'
    ];
}

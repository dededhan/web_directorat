<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'key', 
        'value',
        'threshold_indicator_1',
        'threshold_indicator_2',
        'threshold_indicator_3',
        'threshold_indicator_4',
        'threshold_indicator_5',
        'threshold_indicator_6'
    ];
}
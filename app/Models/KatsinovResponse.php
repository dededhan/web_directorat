<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KatsinovResponse extends Model
{
    protected $fillable = [
        'katsinov_id', 
        'indicator_number',
        'row_number',
        'aspect',
        'score'
    ];

    public function katsinov()
    {
        return $this->belongsTo(Katsinov::class);
    }
}
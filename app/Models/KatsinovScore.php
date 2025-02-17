<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KatsinovScore extends Model
{
    protected $fillable = [
        'katsinov_id', 'indicator_number', 'technology', 'organization',
        'risk', 'market', 'partnership', 'manufacturing', 'investment'
    ];

    public function katsinov()
    {
        return $this->belongsTo(Katsinov::class);
    }
}
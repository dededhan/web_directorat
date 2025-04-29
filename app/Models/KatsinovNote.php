<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'katsinov_id',
        'indicator_number',
        'notes'
    ];

    public function katsinov()
    {
        return $this->belongsTo(Katsinov::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovBerita extends Model
{
    /** @use HasFactory<\Database\Factories\KatsinovBeritaFactory> */
    use HasFactory;

    protected $fillable = [
        'day', 
        'date',
        'month',
        'year',
        'yearfull',
        'decree',
        'place',
        'title',
        'type',
        'tki',
        'opinion',
        'sign_date',
        'katsinov_id', 
    ];

    public function katsinovs(){
        return $this->belongsTo(Katsinov::class);
    }
}

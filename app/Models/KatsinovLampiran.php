<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovLampiran extends Model
{
    /** @use HasFactory<\Database\Factories\KatsinovLampiranFactory> */
    use HasFactory;

    protected $fillable = [
        'path',
        'attribute',
        'type',
        'katsinov_id'
    ];

    public function katsinovs(){
        return $this->belongsTo(User::class);
    }
}

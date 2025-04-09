<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovInovasi extends Model
{
    /** @use HasFactory<\Database\Factories\KatsinovInovasiFactory> */
    use HasFactory;
    protected $fillable = [ 
        'title', 
        'sub_title',
        'introduction',
        'tech_product',
        'supremacy',
        'patent',
        'tech_preparation',
        'market_preparation',
        'name',
        'phone',
        'mobile',
        'fax',
        'email',
        'katsinov_id'
    ];

    public function katsinovs(){
        return $this->belongsTo(Katsinov::class);
    }
}

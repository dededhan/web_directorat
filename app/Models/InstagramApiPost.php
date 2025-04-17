<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagramApiPost extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'instagram_id',
        'title',
        'caption',
        'media_url',
        'permalink',
        'posted_at',
        'is_active'
    ];
    
    protected $casts = [
        'posted_at' => 'datetime',
        'is_active' => 'boolean'
    ];
}
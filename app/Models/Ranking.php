<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ranking extends Model
{
    use HasFactory;

    protected $fillable = ['judul', 'score_ranking', 'slug', 'gambar', 'deskripsi'];

    // Auto-generate slug from title before saving
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ranking) {
            $ranking->slug = Str::slug($ranking->judul);
        });

        static::updating(function ($ranking) {
            $ranking->slug = Str::slug($ranking->judul);
        });
    }
}
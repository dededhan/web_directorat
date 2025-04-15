<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaImage extends Model
{
    protected $fillable = ['berita_id', 'path'];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}
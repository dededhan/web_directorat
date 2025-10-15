<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLayanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'image', 
        'judul',
        'judul_en', 
        'url',
        'deskripsi',
        'deskripsi_en',
        'status',
        'kategori'
    ];

    protected $casts = [];

    public function getTranslatedTitle()
    {
        return app()->getLocale() === 'en' && $this->judul_en 
            ? $this->judul_en 
            : $this->judul;
    }

    public function getTranslatedDescription()
    {
        return app()->getLocale() === 'en' && $this->deskripsi_en 
            ? $this->deskripsi_en 
            : $this->deskripsi;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumumans'; // Ta
    // app/Models/Pengumuman.php
protected $fillable = [
    'judul_pengumuman',
    'judul_pengumuman_en', 
    'icon', 
    'isi_pengumuman',
    'isi_pengumuman_en', 
    'status'
];

public function getTranslatedTitle()
{
    return app()->getLocale() === 'en' && $this->judul_pengumuman_en 
        ? $this->judul_pengumuman_en 
        : $this->judul_pengumuman;
}

public function getTranslatedContent()
{
    return app()->getLocale() === 'en' && $this->isi_pengumuman_en 
        ? $this->isi_pengumuman_en 
        : $this->isi_pengumuman;
}
}

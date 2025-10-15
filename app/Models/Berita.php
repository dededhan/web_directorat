<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'tanggal',
        'judul',
        'judul_en',
        'slug', 
        'isi',
        'isi_en',
        'gambar'
        
    ];

    public function getTranslatedTitle()
    {
        return app()->getLocale() === 'en' && $this->judul_en 
            ? $this->judul_en 
            : $this->judul;
    }

    public function getTranslatedContent()
    {
        return app()->getLocale() === 'en' && $this->isi_en 
            ? $this->isi_en 
            : $this->isi;
    }
    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($berita) {
            // If no slug was provided, generate one from the title
            if (!$berita->slug) {
                $berita->slug = $berita->generateUniqueSlug($berita->judul);
            }
        });

        static::updating(function ($berita) {
            // Only regenerate slug if title changed and slug wasn't explicitly set
            if ($berita->isDirty('judul') && !$berita->isDirty('slug')) {
                $berita->slug = $berita->generateUniqueSlug($berita->judul);
            }
        });
    }

    public function images()
    {
        return $this->hasMany(BeritaImage::class);
    }

    // Generate a unique slug
    public function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        // Make sure the slug is unique
        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    // Instead of relying on route model binding with ID,
    // use slug as the default route key 
    public function getRouteKeyName()
    {
        return 'slug';
    }

    
}
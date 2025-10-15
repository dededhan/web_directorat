<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukInovasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produk_inovasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_produk',
        'nama_produk_en',
        'inovator',
        'inovator_en',
        'deskripsi',
        'deskripsi_en',
        'nomor_paten',
        'gambar',
        'foto_poster',       
        'video_type',      
        'video_path',  
        'kategori',     
        'link_ebook',  
    ];
    
    /**
     * Get the translated product name based on current locale
     * 
     * @return string
     */
    public function getTranslatedName(): string
    {
        return app()->getLocale() === 'en' && $this->nama_produk_en 
            ? $this->nama_produk_en 
            : $this->nama_produk;
    }
    
    /**
     * Get the translated description based on current locale
     * 
     * @return string|null
     */
    public function getTranslatedDescription(): ?string
    {
        return app()->getLocale() === 'en' && $this->deskripsi_en 
            ? $this->deskripsi_en 
            : $this->deskripsi;
    }
}

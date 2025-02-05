<?php
// File: app/Models/Sustainability.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sustainability extends Model
{
    protected $fillable = [
        'judul_kegiatan',
        'tanggal_kegiatan',
        'fakultas',
        'prodi',
        'link_kegiatan',
        'deskripsi_kegiatan',
    ];
    protected $guarded = [];
    protected $casts = [
        'tanggal_kegiatan' => 'date'
    ];
    public function photos()
    {
        return $this->hasMany(SustainabilityPhoto::class);
    }
}

// SustainabilityPhoto.php

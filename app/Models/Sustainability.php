<?php
// File: app/Models/Sustainability.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Sustainability extends Model
{
    protected $fillable = [
        'judul_kegiatan',
        'tanggal_kegiatan',
        'fakultas',
        'prodi',
        'link_kegiatan',
        'deskripsi_kegiatan',
        'user_id',         // Added
        'sdg_goal',
    ];
    protected $guarded = [];
    protected $casts = [
        'tanggal_kegiatan' => 'date'
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(SustainabilityPhoto::class);
    }
    
    public function user(): BelongsTo // Added
    {
        return $this->belongsTo(User::class); // Assuming your User model is in App\Models\User
    }
}

// SustainabilityPhoto.php

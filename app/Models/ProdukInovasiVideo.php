<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukInovasiVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_inovasi_id',
        'type',
        'path',
    ];

    public function produkInovasi()
    {
        return $this->belongsTo(ProdukInovasi::class);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::deleting(function ($video) {
            // If the video is an MP4, delete the file from storage
            if ($video->type === 'mp4' && $video->path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($video->path);
            }
        });
    }
}
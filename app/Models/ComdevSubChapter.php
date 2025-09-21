<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevSubChapter extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Cast tipe data untuk kolom periode.
     */
    protected $casts = [
        'periode_awal' => 'datetime',
        'periode_akhir' => 'datetime',
    ];

    /**
     * Relasi: Sub-Bab ini milik Modul mana.
     */
    public function module()
    {
        return $this->belongsTo(ComdevModule::class, 'comdev_module_id');
    }
    public function reviews()
    {
        return $this->hasMany(ComdevReview::class, 'comdev_sub_chapter_id');
    }
}

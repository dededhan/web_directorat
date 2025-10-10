<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulSubChapter extends Model
{
    use HasFactory;
    
    protected $table = 'modul_sub_chapter';
    
    protected $fillable = [
        'modul_akhir_id',
        'judul_sub_chapter',
        'deskripsi',
        'tipe_input',
        'is_wajib',
        'urutan',
    ];
    
    protected $casts = [
        'is_wajib' => 'boolean',
    ];
    
    public function modul()
    {
        return $this->belongsTo(ModulAkhir::class, 'modul_akhir_id');
    }
    
    public function submissionFiles()
    {
        return $this->hasMany(ModulSubmissionFile::class, 'modul_sub_chapter_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(ModulReview::class, 'modul_sub_chapter_id');
    }
}

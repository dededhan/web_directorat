<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulAkhir extends Model
{
    use HasFactory;
    
    protected $table = 'modul_akhir';
    
    protected $fillable = [
        'sesi_hibah_modul_id',
        'judul_modul',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'urutan',
    ];
    
    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
    ];
    
    public function sesi()
    {
        return $this->belongsTo(SesiHibahModul::class, 'sesi_hibah_modul_id');
    }
    
    public function subChapters()
    {
        return $this->hasMany(ModulSubChapter::class, 'modul_akhir_id')->orderBy('urutan');
    }
}

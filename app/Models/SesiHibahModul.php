<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SesiHibahModul extends Model
{
    use HasFactory;
    
    protected $table = 'sesi_hibah_modul';
    
    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'nominal_usulan',
        'periode_awal',
        'periode_akhir',
        'status',
    ];
    
    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'nominal_usulan' => 'decimal:2',
    ];
    
    public function proposals()
    {
        return $this->hasMany(ProposalModul::class, 'sesi_hibah_modul_id');
    }
    
    public function moduls()
    {
        return $this->hasMany(ModulAkhir::class, 'sesi_hibah_modul_id')->orderBy('urutan');
    }
}

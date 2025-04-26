<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovBerita extends Model
{
    /** @use HasFactory<\Database\Factories\KatsinovBeritaFactory> */
    use HasFactory;

    protected $fillable = [
        'day', 
        'date',
        'month',
        'year',
        'yearfull',
        'decree',
        'place',
        'title',
        'type',
        'tki',
        'opinion',
        'sign_date',
        'katsinov_id', 
        'penanggungjawab',
        'penanggungjawab_pdf',
        'ketua',
        'ketua_pdf',
        'anggota1',
        'anggota1_pdf',
        'anggota2',
        'anggota2_pdf'

    ];

    public function katsinovs(){
        return $this->belongsTo(Katsinov::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternationalFacultyStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'fakultas',
        'universitas_asal',
        'bidang_keahlian',
        'qs_wur',
        'qs_subject',
        'scopus',
        'foto_path',
        'tahun',
        'category'
    ];
}
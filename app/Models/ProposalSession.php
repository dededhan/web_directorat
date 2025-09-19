<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalSession extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'dana_maksimal',
        'periode_awal',
        'periode_akhir',
        'min_anggota',
        'max_anggota',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    /** @use HasFactory<\Database\Factories\RespondenFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'fullname',
        'jabatan',
        'instansi',
        'email',
        'phone_responden',
        'nama_dosen_pengusul',
        'phone_dosen',
        'fakultas',
        'category',
        'status',
         'user_id' ,
        // 'user_id', // Uncomment if you have this column and want to update it
        // 'tahun',   // Uncomment if you have this column and want to update it
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    /** @use HasFactory<\Database\Factories\RespondenFactory> */
    use HasFactory;

    protected static function booted()
    {
        static::created(function (Responden $responden) {
            if (!empty($responden->email)) {
                RespondenBank::firstOrCreate(
                    ['email' => strtolower(trim($responden->email))],
                    [
                        'first_name' => $responden->fullname ?? 'Unknown',
                        'institution' => $responden->instansi ?? null,
                        'category' => RespondenBank::normalizeCategory($responden->category),
                        'phone' => $responden->phone_responden ?? null,
                        'source' => 'manual',
                        'source_user_id' => $responden->user_id ?? null,
                    ]
                );
            }
        });
    }

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
         'token',
        // 'user_id', // Uncomment if you have this column and want to update it
        // 'tahun',   // Uncomment if you have this column and want to update it
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

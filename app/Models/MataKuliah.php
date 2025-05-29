<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', // Tambahkan ini
        'nama_matkul',
        'semester',
        'kode_matkul',
        'fakultas',
        'prodi',
        'rps_path',
        'deskripsi',
        'sdgs_group', // Tambahkan ini
    ];

    /**
     * Get the user that owns the mata kuliah.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
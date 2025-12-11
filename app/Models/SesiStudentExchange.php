<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiStudentExchange extends Model
{
    use HasFactory;

    protected $table = 'sesi_student_exchange';

    protected $fillable = [
        'nama_sesi',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'status',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
    ];

    /**
     * Get all proposals for this session.
     */
    public function proposals()
    {
        return $this->hasMany(ProposalStudentExchange::class);
    }

    /**
     * Get all modules for this session.
     */
    public function moduls()
    {
        return $this->hasMany(StudentExchangeModul::class, 'sesi_student_exchange_id')->orderBy('urutan');
    }

    /**
     * Check if session is currently open.
     */
    public function isOpen()
    {
        return $this->status === 'dibuka' && 
               now()->between($this->periode_awal, $this->periode_akhir);
    }

    /**
     * Scope to get only open sessions.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'dibuka')
                     ->where('periode_awal', '<=', now())
                     ->where('periode_akhir', '>=', now());
    }
}

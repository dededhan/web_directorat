<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExchangeModul extends Model
{
    use HasFactory;

    protected $table = 'student_exchange_modul';

    protected $fillable = [
        'sesi_student_exchange_id',
        'judul_modul',
        'deskripsi',
        'periode_awal',
        'periode_akhir',
        'urutan',
    ];

    protected $casts = [
        'periode_awal' => 'date',
        'periode_akhir' => 'date',
        'urutan' => 'integer',
    ];

    /**
     * Get the session this modul belongs to.
     */
    public function sesi()
    {
        return $this->belongsTo(SesiStudentExchange::class, 'sesi_student_exchange_id');
    }

    /**
     * Get all sub-chapters for this modul.
     */
    public function subChapters()
    {
        return $this->hasMany(StudentExchangeSubChapter::class)->orderBy('urutan');
    }

    /**
     * Check if modul submission period is open.
     */
    public function isOpen()
    {
        if (!$this->periode_awal || !$this->periode_akhir) {
            return true; // Always open if no dates set
        }
        
        return now()->between($this->periode_awal, $this->periode_akhir);
    }
}

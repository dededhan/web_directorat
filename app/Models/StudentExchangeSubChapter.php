<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExchangeSubChapter extends Model
{
    use HasFactory;

    protected $table = 'student_exchange_sub_chapter';

    protected $fillable = [
        'student_exchange_modul_id',
        'judul_sub_chapter',
        'deskripsi',
        'tipe_input',
        'is_wajib',
        'urutan',
    ];

    protected $casts = [
        'is_wajib' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Get the modul this sub-chapter belongs to.
     */
    public function modul()
    {
        return $this->belongsTo(StudentExchangeModul::class, 'student_exchange_modul_id');
    }

    /**
     * Get all submission files for this sub-chapter.
     */
    public function submissionFiles()
    {
        return $this->hasMany(StudentExchangeSubmissionFile::class);
    }

    /**
     * Get all reviews for this sub-chapter.
     */
    public function reviews()
    {
        return $this->hasMany(StudentExchangeReview::class);
    }

    /**
     * Check if PDF upload is allowed.
     */
    public function allowsPdf()
    {
        return in_array($this->tipe_input, ['pdf', 'both']);
    }

    /**
     * Check if link URL is allowed.
     */
    public function allowsLink()
    {
        return in_array($this->tipe_input, ['link', 'both']);
    }
}

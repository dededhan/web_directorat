<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevSubmissionFile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'comdev_submission_id',
        'comdev_sub_chapter_id',
        'user_id',
        'type', 
        'file_path',
        'original_filename',
        'url',
    ];

    /**
     * Mendefinisikan relasi bahwa file ini milik satu submission.
     */
    public function submission()
    {
        return $this->belongsTo(ComdevSubmission::class, 'comdev_submission_id');
    }

    /**
     * Mendefinisikan relasi bahwa file ini milik satu sub-bab.
     */
    public function subChapter()
    {
        return $this->belongsTo(ComdevSubChapter::class, 'comdev_sub_chapter_id');
    }

    /**
     * Mendefinisikan relasi bahwa file ini diunggah oleh satu user (dosen).
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

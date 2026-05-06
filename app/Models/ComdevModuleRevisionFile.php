<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevModuleRevisionFile extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Relasi ke submission.
     */
    public function submission()
    {
        return $this->belongsTo(ComdevSubmission::class, 'comdev_submission_id');
    }

    /**
     * Relasi ke modul.
     */
    public function module()
    {
        return $this->belongsTo(ComdevModule::class, 'comdev_module_id');
    }

    /**
     * Relasi ke sub chapter.
     */
    public function subChapter()
    {
        return $this->belongsTo(ComdevSubChapter::class, 'comdev_sub_chapter_id');
    }

    /**
     * Relasi ke user (dosen) yang mengupload.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

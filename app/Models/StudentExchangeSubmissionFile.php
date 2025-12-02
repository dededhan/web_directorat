<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExchangeSubmissionFile extends Model
{
    use HasFactory;

    protected $table = 'student_exchange_submission_files';

    protected $fillable = [
        'proposal_student_exchange_id',
        'student_exchange_sub_chapter_id',
        'file_path',
        'link_url',
        'tipe_file',
        'keterangan',
    ];

    /**
     * Get the proposal this submission belongs to.
     */
    public function proposal()
    {
        return $this->belongsTo(ProposalStudentExchange::class, 'proposal_student_exchange_id');
    }

    /**
     * Get the sub-chapter this submission is for.
     */
    public function subChapter()
    {
        return $this->belongsTo(StudentExchangeSubChapter::class, 'student_exchange_sub_chapter_id');
    }

    /**
     * Check if this is a file submission.
     */
    public function isFileSubmission()
    {
        return $this->tipe_file === 'pdf' && !empty($this->file_path);
    }

    /**
     * Check if this is a link submission.
     */
    public function isLinkSubmission()
    {
        return $this->tipe_file === 'link' && !empty($this->link_url);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulSubmissionFile extends Model
{
    use HasFactory;
    
    protected $table = 'modul_submission_files';
    
    protected $fillable = [
        'proposal_modul_id',
        'modul_sub_chapter_id',
        'file_path',
        'link_url',
        'tipe_file',
        'keterangan',
    ];
    
    public function proposal()
    {
        return $this->belongsTo(ProposalModul::class, 'proposal_modul_id');
    }
    
    public function subChapter()
    {
        return $this->belongsTo(ModulSubChapter::class, 'modul_sub_chapter_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApcAuthor extends Model
{
    use HasFactory;

    protected $table = 'apc_authors';

    protected $fillable = [
        'apc_submission_id',
        'urutan',
        'nama',
        'afiliasi',
    ];

    public function submission()
    {
        return $this->belongsTo(ApcSubmission::class, 'apc_submission_id');
    }
}

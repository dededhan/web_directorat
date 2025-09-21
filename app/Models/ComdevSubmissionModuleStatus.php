<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComdevSubmissionModuleStatus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function module()
    {
        return $this->belongsTo(ComdevModule::class, 'comdev_module_id');
    }

    /**
     * Relasi ke submission (jika diperlukan).
     */
    public function submission()
    {
        return $this->belongsTo(ComdevSubmission::class, 'comdev_submission_id');
    }
}

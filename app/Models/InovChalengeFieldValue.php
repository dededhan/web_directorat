<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeFieldValue extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_submission_field_values';

    protected $guarded = ['id'];

    public function submission()
    {
        return $this->belongsTo(InovChalengeSubmission::class, 'inov_chalenge_submission_id');
    }

    public function tahap()
    {
        return $this->belongsTo(InovChalengeTahap::class, 'inov_chalenge_tahap_id');
    }

    public function field()
    {
        return $this->belongsTo(InovChalengeTahapField::class, 'inov_chalenge_tahap_field_id');
    }
}

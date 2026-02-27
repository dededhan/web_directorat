<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeTahapField extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_tahap_fields';

    protected $guarded = ['id'];

    protected $casts = [
        'field_options' => 'array',
        'is_required' => 'boolean',
    ];

    public function tahap()
    {
        return $this->belongsTo(InovChalengeTahap::class, 'inov_chalenge_tahap_id');
    }
}

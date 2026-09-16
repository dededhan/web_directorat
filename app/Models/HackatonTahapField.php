<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonTahapField extends Model
{
    use HasFactory;

    protected $table = 'hackaton_tahap_fields';

    protected $guarded = ['id'];

    protected $casts = [
        'field_options' => 'array',
        'is_required' => 'boolean',
    ];

    public function tahap()
    {
        return $this->belongsTo(HackatonTahap::class, 'hackaton_tahap_id');
    }

    public function section()
    {
        return $this->belongsTo(HackatonTahapSection::class, 'hackaton_tahap_section_id');
    }
}

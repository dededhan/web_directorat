<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HackatonTahapSection extends Model
{
    use HasFactory;

    protected $table = 'hackaton_tahap_sections';

    protected $guarded = ['id'];

    public function tahap()
    {
        return $this->belongsTo(HackatonTahap::class, 'hackaton_tahap_id');
    }

    public function fields()
    {
        return $this->hasMany(HackatonTahapField::class, 'hackaton_tahap_section_id')
            ->orderBy('urutan');
    }
}

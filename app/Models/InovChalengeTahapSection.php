<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovChalengeTahapSection extends Model
{
    use HasFactory;

    protected $table = 'inov_chalenge_tahap_sections';

    protected $guarded = ['id'];

    public function tahap()
    {
        return $this->belongsTo(InovChalengeTahap::class, 'inov_chalenge_tahap_id');
    }

    public function fields()
    {
        return $this->hasMany(InovChalengeTahapField::class, 'inov_chalenge_tahap_section_id')
            ->orderBy('urutan');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovInformasi extends Model
{
    /** @use HasFactory<\Database\Factories\KatsinovInformasiFactory> */
    use HasFactory;
    protected $fillable = [
        'pic',
        'address',
        'institution',
        'phone',
        'fax',
        'innovation_title',
        'innovation_name',
        'innovation_type',
        'innovation_field',
        'innovation_application',
        'innovation_duration',
        'innovation_year',
        'innovation_summary',
        'innovation_supremacy',
        'innovation_novelty',
        'katsinov_id',
    ];
    public function katsinovs(){
        return $this->belongsTo(Katsinov::class);
    }

    public function katsinovInformasiCollections(){
        return $this->hasMany(KatsinovInformasiCollection::class);
    }
}

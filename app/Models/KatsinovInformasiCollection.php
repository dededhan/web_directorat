<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatsinovInformasiCollection extends Model
{
    /** @use HasFactory<\Database\Factories\KatsinovInformasiCollectionFactory> */
    use HasFactory;
    protected $fillable = [
        'field',
        'index',
        'attribute',
        'value',
        'katsinov_informasi_id',
    ];

    public function katsinovInformasis(){
        return $this->belongsTo(KatsinovInformasi::class);
    }
}

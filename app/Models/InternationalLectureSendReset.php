<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternationalLectureSendReset extends Model
{
    protected $fillable = [
        'dosen_internasional_id',
        'reset_date',
        'reset_at',
        'reset_by',
    ];

    protected $casts = [
        'reset_date' => 'date',
        'reset_at' => 'datetime',
    ];

    public function lecturer()
    {
        return $this->belongsTo(DosenInternasional::class, 'dosen_internasional_id');
    }
}

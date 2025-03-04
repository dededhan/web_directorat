<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormProgress extends Model
{
    protected $fillable = [
        'innovator_form_id',
        'type',
        'uraian',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'status' => 'string'
    ];
}
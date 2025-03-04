<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormTeamMember extends Model
{
    protected $fillable = [
        'innovator_form_id',
        'nama',
        'keahlian'
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class QuesionerGeneral extends Model
{
    /** @use HasFactory<\Database\Factories\QuesionerGeneralFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}

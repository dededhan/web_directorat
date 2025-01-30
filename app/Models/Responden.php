<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    /** @use HasFactory<\Database\Factories\RespondenFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}

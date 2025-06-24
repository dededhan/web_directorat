<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalEngagementProgram extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'objectives', 'activities', 'order'];
}
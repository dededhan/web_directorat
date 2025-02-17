<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katsinov extends Model
{
    protected $fillable = [
        'title', 'focus_area', 'project_name', 
        'institution', 'address', 'contact', 'assessment_date'
    ];

    public function scores()
    {
        return $this->hasMany(KatsinovScore::class);
    }
}
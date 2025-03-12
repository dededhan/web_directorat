<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Katsinov extends Model
{
    protected $fillable = [
        'title', 'focus_area', 'project_name', 
        'institution', 'address', 'contact', 'assessment_date',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class, '');
    }

    public function scores()
    {
        return $this->hasMany(KatsinovScore::class);
    }
}
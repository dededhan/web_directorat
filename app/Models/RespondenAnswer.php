<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespondenAnswer extends Model
{
    /** @use HasFactory<\Database\Factories\RespondenAnswerFactory> */
    use HasFactory;
    protected $guarded = ['id'];


    public function responden()
    {
        return $this->belongsTo(Responden::class, 'email', 'email');
    }


    public function inputUser()
    {
        return $this->hasOneThrough(
            User::class,
            Responden::class,
            'email', 
            'id', 
            'email', 
            'user_id' 
        );
    }
}

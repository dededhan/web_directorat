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
        return $this->belongsTo(Responden::class, 'responden_id');
    }


    public function getRespondenAttribute()
    {
        //relation user
        $respondenFromRelation = $this->getRelationValue('responden');

        if ($respondenFromRelation) {
            return $respondenFromRelation;
        }

        //relation email
        if ($this->email) {
            $respondenByEmail = Responden::where('email', $this->email)->first();
            if ($respondenByEmail) {
                return $respondenByEmail;
            }
        }

        //opsi telfon
        if (!empty($this->phone)) {
            return Responden::where('phone_responden', $this->phone)->first();
        }
        

        return null;
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


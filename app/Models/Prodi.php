<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;


    protected $table = 'equity_prodi';


    protected $fillable = [
        'fakultas_id',
        'name',
    ];


    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    /**
     * Get the user profiles for the prodi.
     */
    public function userProfiles()
    {
        return $this->hasMany(UserProfile::class, 'prodi_id');
    }
}


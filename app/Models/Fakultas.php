<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    use HasFactory;


    protected $table = 'equity_fakultas';


    protected $fillable = [
        'name',
        'abbreviation',
    ];

     public function prodi()
    {
        return $this->hasMany(Prodi::class, 'fakultas_id');
    }
}


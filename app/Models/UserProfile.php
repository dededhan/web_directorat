<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'equity_user_profiles';


    protected $fillable = [
        'user_id',
        'identifier_number',
        'prodi_id',
        'fakultas_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

        public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}


<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'google_id',
    'avatar',
    'email_verified_at',
    'status',
    ];


    // Relationships
    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function fakultas()
    {
        return $this->hasOne(Fakultas::class);
    }

    public function prodi()
    {
        return $this->hasOne(Prodi::class);
    }

    public function hasRole($role){
        return $this->role === $role;
    }

    public function katsinovs(){
        return $this->hasMany(Katsinov::class, 'user_id');
    }

}
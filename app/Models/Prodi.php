<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    use HasFactory;

    protected $table = 'prodi';
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

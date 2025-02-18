<?php
// app/Models/Dosen.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;
  

    protected $table = 'dosen'; 
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
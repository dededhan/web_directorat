<?php
// app/Models/RisetUnj.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RisetUnj extends Model
{
    use HasFactory;

  protected $table = 'riset_unj'; 
    protected $fillable = [
        'judul',
        'ketua_peneliti',
        'tahun',
        'fakultas',
        'skema',
        'bidang_ilmu',
        'sumber_dana',
        'dana',
    ];
}
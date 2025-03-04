<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormPartner extends Model
{
    protected $fillable = [
        'innovator_form_id',
        'nama_mitra',
        'alamat_mitra',
        'peran_mitra',
        'status_kerjasama'
    ];
}

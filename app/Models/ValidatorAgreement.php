<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidatorAgreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'validator_id',
        'signature_data',
        'ip_address',
        'user_agent',
        'agreed_at',
    ];

    protected $casts = [
        'agreed_at' => 'datetime',
    ];

    /**
     * Relasi ke Form
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Relasi ke Validator (User)
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id');
    }
}

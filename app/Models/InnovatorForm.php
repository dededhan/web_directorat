<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InnovatorForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_penanggungjawab',
        'institusi',
        'alamat_kontak',
        'phone',
        'fax',
        'judul_inovasi',
        'nama_program',
        'jenis_inovasi',
        'jenis_lainnya',
        'bidang_inovasi',
        'bidang_lainnya',
        'aplikasi_manfaat',
        'lama_program',
        'tahun_berjalan',
        'ringkasan_inovasi',
        'kebaruan',
        'keunggulan'
    ];

    public function teamMembers()
    {
        return $this->hasMany(FormTeamMember::class, 'innovator_form_id');
    }

    public function fundingSources()
    {
        return $this->hasMany(FormFundingSource::class, 'innovator_form_id');
    }

    public function partners()
    {
        return $this->hasMany(FormPartner::class, 'innovator_form_id');
    }

    public function progress()
    {
        return $this->hasMany(FormProgress::class, 'innovator_form_id');
    }

    // Accessor untuk progress teknologi
    public function getTechnologyProgressAttribute()
    {
        return $this->progress()->where('type', 'technology')->get();
    }

    // Accessor untuk progress pasar
    public function getMarketProgressAttribute()
    {
        return $this->progress()->where('type', 'market')->get();
    }

    /**
     * Validator relationships for V2
     */
    public function validators()
    {
        return $this->belongsToMany(User::class, 'form_validator_assignments', 'form_id', 'validator_id')
            ->withTimestamps();
    }

    public function validatorAgreements()
    {
        return $this->hasMany(ValidatorAgreement::class, 'form_id');
    }

    public function validatorAssessments()
    {
        return $this->hasMany(ValidatorAssessment::class, 'form_id');
    }

    public function validatorProgress()
    {
        return $this->hasMany(ValidatorProgress::class, 'form_id');
    }

    public function beritaAcara()
    {
        return $this->hasOne(BeritaAcara::class, 'form_id');
    }

    public function validatorRecords()
    {
        return $this->hasMany(ValidatorRecord::class, 'form_id');
    }

    // Get user/dosen who submitted the form
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalStudentExchange extends Model
{
    use HasFactory;

    protected $table = 'proposal_student_exchange';

    protected $fillable = [
        'sesi_student_exchange_id',
        'user_id',
        'judul_kegiatan',
        'ringkasan_kegiatan',
        'sdgs_fokus',
        'sdgs_pendukung',
        'jenis_kegiatan',
        'jumlah_peserta',
        'sks',
        'nama_mahasiswa_path',
        'mata_kuliah_path',
        'rab_path',
        'tanggal_online',
        'tanggal_onsite',
        'status',
        'reviewer_id',
        'komentar_admin',
        'komentar_reviewer',
        'nilai_reviewer',
        'tanggal_review',
        'alasan_penolakan',
    ];

    protected $casts = [
        'sdgs_fokus' => 'array',
        'sdgs_pendukung' => 'array',
        'tanggal_online' => 'date',
        'tanggal_onsite' => 'date',
        'tanggal_review' => 'datetime',
        'jumlah_peserta' => 'integer',
        'sks' => 'integer',
        'nilai_reviewer' => 'decimal:2',
    ];

    /**
     * Get the session this proposal belongs to.
     */
    public function sesi()
    {
        return $this->belongsTo(SesiStudentExchange::class, 'sesi_student_exchange_id');
    }

    /**
     * Get the user who created this proposal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assigned reviewer.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the partner institution for this proposal.
     */
    public function mitra()
    {
        return $this->hasOne(StudentExchangeMitra::class);
    }

    /**
     * Get all team members for this proposal.
     */
    public function anggota()
    {
        return $this->hasMany(AnggotaStudentExchange::class)->orderBy('urutan');
    }

    /**
     * Get all submission files for this proposal.
     */
    public function submissionFiles()
    {
        return $this->hasMany(StudentExchangeSubmissionFile::class);
    }

    /**
     * Get all reviews for this proposal.
     */
    public function reviews()
    {
        return $this->hasMany(StudentExchangeReview::class, 'student_exchange_proposal_id');
    }

    /**
     * Get all files for this proposal.
     */
    public function files()
    {
        return $this->hasMany(StudentExchangeSubmissionFile::class, 'proposal_student_exchange_id');
    }

    /**
     * Get all reviewer assignments for this proposal.
     */
    public function reviewerAssignments()
    {
        return $this->hasMany(ReviewerStudentExchangeAssignment::class);
    }

    /**
     * Check if proposal can be edited.
     */
    public function canBeEdited()
    {
        return in_array($this->status, ['draft', 'diajukan']);
    }

    /**
     * Check if proposal can be deleted.
     */
    public function canBeDeleted()
    {
        return $this->status === 'draft';
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to filter by jenis kegiatan.
     */
    public function scopeByJenisKegiatan($query, $jenis)
    {
        return $query->where('jenis_kegiatan', $jenis);
    }
}

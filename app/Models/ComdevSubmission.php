<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\ComdevStatusEnum;

class ComdevSubmission extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    protected $casts = [
        'status' => ComdevStatusEnum::class,
        'kata_kunci' => 'array',
        'sdgs' => 'array',
        'sdgs_fokus' => 'array',
        'sdgs_pendukung' => 'array',
        'mitra_nasional' => 'array',
        'mitra_internasional' => 'array',
        'luaran_wajib' => 'array',
        'luaran_opsional' => 'array',
    ];

    protected function sdgsFokus(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->normalizeArrayValue($value)
        );
    }

    protected function sdgsPendukung(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->normalizeArrayValue($value)
        );
    }

    private function normalizeArrayValue($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value === null) {
            return [];
        }

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed === '') {
                return [];
            }

            $decoded = json_decode($trimmed, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }

            return [$trimmed];
        }

        if ($value instanceof \Illuminate\Support\Collection) {
            return $value->all();
        }

        if (is_iterable($value)) {
            return iterator_to_array($value);
        }

        return [];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sesi()
    {
        return $this->belongsTo(ComdevProposal::class, 'comdev_proposal_id');
    }

    public function members()
    {
        return $this->hasMany(ProposalMember::class);
    }
    
    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'comdev_submission_reviewer', 'comdev_submission_id', 'reviewer_id');
    }

    public function files()
    {
        return $this->hasMany(ComdevSubmissionFile::class, 'comdev_submission_id');
    }

    
    public function reviews()
    {
        return $this->hasMany(ComdevReview::class, 'comdev_submission_id');
    }
    
    public function moduleStatuses()
    {
        return $this->hasMany(ComdevSubmissionModuleStatus::class, 'comdev_submission_id');
    }
    public function activeModuleStatus()
    {
        return $this->hasOne(ComdevSubmissionModuleStatus::class, 'comdev_submission_id')
            ->join('comdev_modules', 'comdev_submission_module_statuses.comdev_module_id', '=', 'comdev_modules.id')
            ->where('comdev_submission_module_statuses.status', '!=', 'lolos')
            ->orderBy('comdev_modules.urutan', 'asc');
    }
    public function logbooks()
    {
        return $this->hasMany(Logbook::class, 'comdev_submission_id')->orderBy('activity_date', 'desc');
    }

    public function revisionFiles()
    {
        return $this->hasMany(ComdevModuleRevisionFile::class, 'comdev_submission_id');
    }

}

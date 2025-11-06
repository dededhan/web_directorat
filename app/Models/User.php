<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hasRole($role)
    {

        if (is_array($role)) {
            return in_array($this->role, $role);
        }

        return $this->role === $role;
    }

    public function exams(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class, 'exam_user')
            ->withPivot('start_time', 'end_time', 'status')
            ->withTimestamps();
    }

    public function examSessions(): HasMany
    {
        return $this->hasMany(ExamSession::class);
    }

    public function katsinovs()
    {
        return $this->hasMany(Katsinov::class, 'user_id');
    }
    public function submissionsToReview()
    {
        return $this->belongsToMany(ComdevSubmission::class, 'comdev_submission_reviewer', 'reviewer_id', 'comdev_submission_id');
    }


        public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }

        public function prodi(): HasOneThrough
    {
        return $this->hasOneThrough(
            Prodi::class,
            UserProfile::class,
            'user_id', 
            'id',      
            'id',    
            'prodi_id'
        );
    }

    public function proposalModuls()
    {
        return $this->hasMany(ProposalModul::class, 'user_id');
    }

    public function reviewerProposalModuls()
    {
        return $this->hasMany(ProposalModul::class, 'reviewer_id');
    }

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function prodiDirect()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function sulitestProfile(): HasOne
    {
        return $this->hasOne(SulitestPesertaProfile::class);
    }

    public function subAdminAssignment(): HasOne
    {
        return $this->hasOne(SubAdminAssignment::class);
    }
}

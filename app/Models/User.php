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

    /**
     * Display label for User unit / level:
     * a. If admin pemeringkatan / direktorat -> 'Direktorat'
     * b. If fakultas -> 'Fakultas - [Nama Fakultas]'
     * c. If prodi -> '[Nama Prodi]'
     */
    public function getUnitLabelAttribute(): string
    {
        $role = $this->role ?? '';

        if (in_array($role, ['admin_pemeringkatan', 'admin_direktorat', 'super_admin', 'kepala_direktorat', 'kepala_sub_direktorat', 'wr3', 'admin_hilirisasi', 'admin_inovasi'])) {
            return 'Direktorat';
        }

        if (in_array($role, ['fakultas', 'equity_fakultas'])) {
            $fakName = $this->fakultas?->name ?? $this->profile?->fakultas?->name ?? $this->profile?->fakultas?->abbreviation ?? $this->name;
            if (!empty($fakName)) {
                return str_starts_with(strtoupper($fakName), 'FAKULTAS') ? $fakName : 'Fakultas - ' . $fakName;
            }
            return 'Fakultas';
        }

        if ($role === 'prodi') {
            $prodiName = $this->prodiDirect?->name ?? $this->profile?->prodi?->name ?? $this->name;
            return $prodiName ?: 'Prodi';
        }

        return $this->name ?: 'Direktorat';
    }

    /**
     * Check if user is Directorate Admin (Pemeringkatan / Super Admin / Admin Direktorat).
     */
    public function isDirectorateAdmin(): bool
    {
        return in_array($this->role, ['admin_pemeringkatan', 'admin_direktorat', 'super_admin']);
    }

    /**
     * Check if user is Fakultas account.
     */
    public function isFakultas(): bool
    {
        return in_array($this->role, ['fakultas', 'equity_fakultas']);
    }

    /**
     * Check if user is Prodi account.
     */
    public function isProdi(): bool
    {
        return $this->role === 'prodi';
    }

    /**
     * Get array of User IDs accessible by this user.
     * Returns null for directorate admin (meaning unrestricted / all access).
     * Returns [fakultas_user_id, ...prodi_user_ids] for fakultas.
     * Returns [prodi_user_id] for prodi.
     */
    public function getAccessibleUserIds(): ?array
    {
        if ($this->isDirectorateAdmin()) {
            return null; // All access
        }

        if ($this->isFakultas()) {
            $prefix = strtoupper(trim($this->name));
            $prodiIds = self::where('role', 'prodi')
                ->where('name', 'LIKE', $prefix . '-%')
                ->pluck('id')
                ->toArray();
            $prodiIds[] = $this->id;
            return $prodiIds;
        }

        if ($this->isProdi()) {
            return [$this->id];
        }

        return [$this->id];
    }
}

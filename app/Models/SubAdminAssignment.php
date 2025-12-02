<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubAdminAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assigned_modules',
    ];

    protected $casts = [
        'assigned_modules' => 'array',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Daftar module yang tersedia
     */
    public static function availableModules()
    {
        return [
            'comdev' => 'Community Development',
            'hibah_modul' => 'Hibah Modul Ajar',
            'student_exchange' => 'Student Exchange',
            'apc' => 'Article Processing Cost',
            'fee_reviewer' => 'Insentif Reviewer',
            'fee_editor' => 'Insentif Editor',
            'presenting' => 'Bantuan Presentasi',
            'matchresearch' => 'Matchmaking Riset',
            'visiting_professors' => 'Visiting Professor',
            'joint_supervision' => 'Joint Supervision',
            'employer_meetings' => 'Employer Meetings',
        ];
    }

    /**
     * Cek apakah user memiliki akses ke module tertentu
     */
    public function hasAccessTo($moduleKey)
    {
        return in_array($moduleKey, $this->assigned_modules ?? []);
    }
}

<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Models\HackatonRegistration;
use Illuminate\Support\Facades\Auth;

class ParticipantDashboardController extends Controller
{
    private const ROLE_LABELS = [
        'hackaton_dosen' => 'Dosen',
        'hackaton_tendik' => 'Tendik',
        'hackaton_alumni' => 'Alumni',
        'hackaton_peneliti' => 'Peneliti',
        'hackaton_dudi' => 'DUDI',
        'hackaton_pppk' => 'PPPK',
        'hackaton_mahasiswa' => 'Mahasiswa',
        'dosen' => 'Dosen',
        'tendik' => 'Tendik',
        'alumni' => 'Alumni',
        'peneliti' => 'Peneliti',
        'dudi' => 'DUDI',
        'pppk' => 'PPPK',
        'mahasiswa' => 'Mahasiswa',
    ];

    private const ROLE_ICONS = [
        'hackaton_dosen' => 'fa-chalkboard-teacher',
        'hackaton_tendik' => 'fa-user-tie',
        'hackaton_alumni' => 'fa-user-graduate',
        'hackaton_peneliti' => 'fa-microscope',
        'hackaton_dudi' => 'fa-building',
        'hackaton_pppk' => 'fa-user-tie',
        'hackaton_mahasiswa' => 'fa-graduation-cap',
        'dosen' => 'fa-chalkboard-teacher',
        'tendik' => 'fa-user-tie',
        'alumni' => 'fa-user-graduate',
        'peneliti' => 'fa-microscope',
        'dudi' => 'fa-building',
        'pppk' => 'fa-user-tie',
        'mahasiswa' => 'fa-graduation-cap',
    ];

    public function index()
    {
        $user = Auth::user();
        $user->load('profile.fakultas', 'profile.prodi');

        $registration = HackatonRegistration::where('email', $user->email)
            ->latest()
            ->first();

        $role = $user->role;
        $baseRole = str_replace('hackaton_', '', $role);

        return view('subdirektorat-inovasi.hackaton.dashboard', [
            'user' => $user,
            'role' => $role,
            'baseRole' => $baseRole,
            'roleLabel' => self::ROLE_LABELS[$role] ?? (self::ROLE_LABELS[$baseRole] ?? ucfirst($baseRole)),
            'roleIcon' => self::ROLE_ICONS[$role] ?? (self::ROLE_ICONS[$baseRole] ?? 'fa-user'),
            'registration' => $registration,
        ]);
    }
}

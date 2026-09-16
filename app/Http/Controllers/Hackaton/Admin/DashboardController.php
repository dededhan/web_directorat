<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonRegistration;
use App\Models\HackatonSession;
use App\Models\HackatonSubmission;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalRegistrations'    => HackatonRegistration::count(),
            'pendingRegistrations'  => HackatonRegistration::where('status', 'pending')->count(),
            'approvedRegistrations' => HackatonRegistration::where('status', 'approved')->count(),
            'declinedRegistrations' => HackatonRegistration::where('status', 'declined')->count(),
            'totalSessions'         => HackatonSession::count(),
            'activeSessions'        => HackatonSession::where('status', 'active')->count(),
            'totalSubmissions'      => HackatonSubmission::count(),
            'totalParticipants'     => User::where('role', 'like', 'hackaton_%')->count(),
        ];

        $recentSubmissions = HackatonSubmission::with(['session', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        $recentRegistrations = HackatonRegistration::latest()
            ->limit(5)
            ->get();

        return view('admin_hackaton.dashboard', compact('stats', 'recentSubmissions', 'recentRegistrations'));
    }
}

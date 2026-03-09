<?php

namespace App\Http\Controllers\InovChalenge\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSession;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalSessions'        => InovChalengeSession::count(),
            'activeSessions'       => InovChalengeSession::where('status', 'active')->count(),
            'totalSubmissions'     => InovChalengeSubmission::count(),
            'pendingRegistrations' => InovChalengeRegistration::where('status', 'pending')->count(),
        ];

        return view('admin_inovchalenge.dashboard', compact('stats'));
    }
}

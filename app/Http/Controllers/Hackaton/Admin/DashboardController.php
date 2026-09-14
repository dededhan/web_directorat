<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalRegistrations' => HackatonRegistration::count(),
            'pendingRegistrations' => HackatonRegistration::where('status', 'pending')->count(),
            'approvedRegistrations' => HackatonRegistration::where('status', 'approved')->count(),
            'declinedRegistrations' => HackatonRegistration::where('status', 'declined')->count(),
        ];

        return view('admin_hackaton.dashboard', compact('stats'));
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureHackatonParticipantHasPhone
{
    /**
     * Exempt roles from the phone completion gate (admins & reviewers).
     */
    private const EXEMPT_ROLES = [
        'superadmin',
        'super_admin',
        'admin',
        'admin_hackaton',
        'admin_inovasi',
        'admin_inovchalenge',
        'admin_direktorat',
        'reviewer_hackaton',
        'reviewer_inovchalenge',
        'reviewer_equity',
        'reviewer_hibah',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Exempt administrators and reviewers
        if (in_array($user->role, self::EXEMPT_ROLES, true)) {
            return $next($request);
        }

        // Check if user has phone number
        if (!$user->hasPhoneNumber()) {
            // Whitelisted routes so user can view dashboard, update phone, or log out
            $allowedRouteNames = [
                'hackaton.dashboard',
                'hackaton.phone.update',
                'hackaton.profile.update',
                'logout',
            ];

            $currentRoute = $request->route()?->getName();

            if (!in_array($currentRoute, $allowedRouteNames, true)) {
                return redirect()->route('hackaton.dashboard')->with('warning', 'Harap lengkapi nomor WhatsApp / HP aktif Anda terlebih dahulu untuk membuka semua fitur Hackathon.');
            }
        }

        return $next($request);
    }
}

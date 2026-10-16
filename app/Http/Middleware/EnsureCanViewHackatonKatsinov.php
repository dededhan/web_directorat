<?php

namespace App\Http\Middleware;

use App\Models\HackatonKatsinovAssessment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCanViewHackatonKatsinov
{
    /**
     * Handle an incoming request.
     * Hanya boleh diakses oleh:
     * 1. Orang tersebut (Pembuat assessment atau Ketua / Anggota Tim proposal terkait)
     * 2. Admin (admin_hackaton, superadmin, admin)
     * 3. Reviewer (reviewer_hackaton, reviewer_inovchalenge, atau reviewer yang ditugaskan ke proposal terkait)
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->guest(route('login'));
        }

        // Resolusi instance Katsinov dari parameter route
        $katsinov = $request->route('katsinov');

        if (!$katsinov instanceof HackatonKatsinovAssessment) {
            $identifier = $katsinov ?? $request->route('token') ?? $request->route('id');
            if (is_numeric($identifier)) {
                $katsinov = HackatonKatsinovAssessment::with(['submission.members', 'submission.reviewers'])->find($identifier);
            } elseif (is_string($identifier)) {
                $katsinov = HackatonKatsinovAssessment::with(['submission.members', 'submission.reviewers'])->where('share_token', $identifier)->first();
            }
        } else {
            $katsinov->loadMissing(['submission.members', 'submission.reviewers']);
        }

        if (!$katsinov) {
            abort(404, 'Dokumen KATSINOV tidak ditemukan.');
        }

        // 1. Cek Admin
        if (in_array($user->role, [
            'admin_hackaton',
            'superadmin',
            'admin',
            'admin_inovasi',
            'admin_inovchalenge',
            'admin_direktorat',
        ])) {
            return $next($request);
        }

        // 2. Cek Reviewer
        if (in_array($user->role, [
            'reviewer_hackaton',
            'reviewer_inovchalenge',
            'reviewer_equity',
        ])) {
            return $next($request);
        }
        if ($katsinov->hackaton_submission_id && $katsinov->submission) {
            if ($katsinov->submission->reviewers()->where('users.id', $user->id)->exists()) {
                return $next($request);
            }
        }

        // 3. Cek Orang Tersebut (Pembuat assessment, Ketua tim, atau Anggota Tim)
        if ($katsinov->user_id === $user->id) {
            return $next($request);
        }

        if ($katsinov->hackaton_submission_id && $katsinov->submission) {
            // Ketua pengusul
            if ($katsinov->submission->user_id === $user->id) {
                return $next($request);
            }
            // Anggota tim aktif / terdaftar
            if ($katsinov->submission->members()->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->orWhereHas('user', function ($qu) use ($user) {
                        $qu->where('email', $user->email);
                    });
            })->exists()) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak. Dokumen KATSINOV ini bersifat privat dan hanya dapat diakses oleh pengusul yang bersangkutan, reviewer, atau admin.');
    }
}

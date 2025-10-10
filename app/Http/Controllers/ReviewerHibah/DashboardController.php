<?php

namespace App\Http\Controllers\ReviewerHibah;

use App\Http\Controllers\Controller;
use App\Models\ProposalModul;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Total assignments
        $totalAssignments = ProposalModul::where('reviewer_id', $userId)->count();
        
        // Pending reviews (menunggu_direview)
        $pendingReviews = ProposalModul::where('reviewer_id', $userId)
            ->where('status', 'menunggu_direview')
            ->count();
        
        // Completed reviews (sudah ada komentar_reviewer)
        $completedReviews = ProposalModul::where('reviewer_id', $userId)
            ->whereNotNull('komentar_reviewer')
            ->whereIn('status', ['lolos', 'tidak_lolos'])
            ->count();
        
        // Recent assignments (5 terbaru)
        $recentAssignments = ProposalModul::where('reviewer_id', $userId)
            ->with(['user', 'sesi'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('reviewer_hibah.dashboard', compact(
            'totalAssignments',
            'pendingReviews',
            'completedReviews',
            'recentAssignments'
        ));
    }
}

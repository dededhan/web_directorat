<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSubmissionMember;
use Illuminate\Support\Facades\Auth;

class AlumniController extends Controller
{
    /**
     * Show pending invitations for the logged-in alumni.
     */
    public function invitations()
    {
        $invitations = InovChalengeSubmissionMember::where('user_id', Auth::id())
            ->where('tipe_anggota', 'alumni')
            ->with(['submission.session', 'submission.user'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.alumni.inovchalenge.invitations.index', compact('invitations'));
    }

    /**
     * Approve an invitation.
     */
    public function approve(InovChalengeSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403);
        abort_if($member->approval_status !== 'pending', 403, 'Undangan ini sudah direspon.');

        $member->update([
            'approval_status' => 'approved',
            'responded_at' => now(),
        ]);

        return back()->with('success', 'Undangan berhasil diterima.');
    }

    /**
     * Reject an invitation.
     */
    public function reject(InovChalengeSubmissionMember $member)
    {
        abort_if($member->user_id !== Auth::id(), 403);
        abort_if($member->approval_status !== 'pending', 403, 'Undangan ini sudah direspon.');

        $member->update([
            'approval_status' => 'rejected',
            'responded_at' => now(),
        ]);

        return back()->with('success', 'Undangan berhasil ditolak.');
    }
}

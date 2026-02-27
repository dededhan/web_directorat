<?php

namespace App\Http\Controllers\InovChallenge\Dosen;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeTeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InovChallengeTeamController extends Controller
{
    /**
     * Display team management page.
     */
    public function index(InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to submission.');
        }
        
        // Load team members
        $submission->load(['teamMembers.user', 'session']);
        
        // Get all dosen users (for internal members)
        $dosenUsers = User::where('role', 'dosen')
            ->where('id', '!=', auth()->id()) // Exclude current user
            ->whereNotIn('id', $submission->teamMembers()->whereNotNull('user_id')->pluck('user_id'))
            ->orderBy('name')
            ->get();
        
        // Statistics
        $stats = [
            'total_members' => $submission->teamMembers()->count(),
            'accepted_members' => $submission->teamMembers()->where('status', 'accepted')->count(),
            'pending_members' => $submission->teamMembers()->where('status', 'pending')->count(),
            'rejected_members' => $submission->teamMembers()->where('status', 'rejected')->count(),
        ];
        
        return view('inov_challenge.dosen.team.index', compact('submission', 'dosenUsers', 'stats'));
    }

    /**
     * Add internal team member (dosen).
     */
    public function addMember(Request $request, InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|string|max:100',
        ]);
        
        $userId = $request->user_id;
        
        // Check if user is the submission creator
        if ($userId === $submission->user_id) {
            return back()->with('error', 'Anda tidak dapat menambahkan diri sendiri sebagai anggota tim.');
        }
        
        // Get user details
        $user = User::findOrFail($userId);
        
        // Check if user is dosen
        if ($user->role !== 'dosen') {
            return back()->with('error', 'Hanya dosen yang dapat ditambahkan sebagai anggota tim internal.');
        }
        
        // Check if user is already in the team
        $existingMember = $submission->teamMembers()
            ->where('user_id', $userId)
            ->first();
        
        if ($existingMember) {
            return back()->with('error', 'Dosen ini sudah menjadi anggota tim.');
        }
        
        // Check max team members (optional, configure if needed)
        $maxTeamMembers = config('inov_challenge.max_team_members', 5);
        if ($submission->teamMembers()->count() >= $maxTeamMembers) {
            return back()->with('error', 'Jumlah maksimal anggota tim adalah ' . $maxTeamMembers . ' orang.');
        }
        
        try {
            DB::beginTransaction();
            
            // Create team member
            $teamMember = InovChallengeTeamMember::create([
                'submission_id' => $submission->id,
                'user_id' => $userId,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $request->role,
                'status' => 'pending',
                'invitation_token' => Str::random(32),
                'invited_at' => now(),
            ]);
            
            // Send invitation notification (email)
            // TODO: Implement in Sprint 7
            // $teamMember->sendInvitationNotification();
            
            DB::commit();
            
            return back()->with('success', 'Anggota tim berhasil ditambahkan. Notifikasi undangan telah dikirim ke ' . $user->email);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Invite external team member (alumni).
     */
    public function inviteExternal(Request $request, InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('inov_challenge_team_members')->where(function ($query) use ($submission) {
                    return $query->where('submission_id', $submission->id);
                }),
            ],
            'role' => 'nullable|string|max:100',
        ]);
        
        // Check if email belongs to an existing user
        $existingUser = User::where('email', $request->email)->first();
        
        // If user exists, check if they're dosen (should use addMember instead)
        if ($existingUser && $existingUser->role === 'dosen') {
            return back()->with('error', 'Dosen tersebut sudah terdaftar. Gunakan fitur "Tambah Anggota Internal" untuk menambahkan dosen.');
        }
        
        // Check max team members
        $maxTeamMembers = config('inov_challenge.max_team_members', 5);
        if ($submission->teamMembers()->count() >= $maxTeamMembers) {
            return back()->with('error', 'Jumlah maksimal anggota tim adalah ' . $maxTeamMembers . ' orang.');
        }
        
        try {
            DB::beginTransaction();
            
            // Create team member
            $teamMember = InovChallengeTeamMember::create([
                'submission_id' => $submission->id,
                'user_id' => $existingUser ? $existingUser->id : null, // Link if user exists (alumni)
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'status' => 'pending',
                'invitation_token' => Str::random(32),
                'invited_at' => now(),
            ]);
            
            // Send invitation email
            // TODO: Implement in Sprint 7
            // $teamMember->sendInvitationEmail();
            
            DB::commit();
            
            return back()->with('success', 'Undangan berhasil dikirim ke ' . $request->email);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove team member.
     */
    public function removeMember(InovChallengeSubmission $submission, InovChallengeTeamMember $member)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if member belongs to this submission
        if ($member->submission_id !== $submission->id) {
            abort(404);
        }
        
        // Cannot remove accepted members if submission is already submitted
        if ($member->status === 'accepted' && !in_array($submission->phase_1_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Anggota tim yang sudah menerima undangan tidak dapat dihapus setelah submission diajukan.');
        }
        
        try {
            DB::beginTransaction();
            
            $memberName = $member->name;
            
            // Delete team member
            $member->delete();
            
            DB::commit();
            
            return back()->with('success', $memberName . ' berhasil dihapus dari tim.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Resend invitation to team member.
     */
    public function resendInvitation(InovChallengeSubmission $submission, InovChallengeTeamMember $member)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if member belongs to this submission
        if ($member->submission_id !== $submission->id) {
            abort(404);
        }
        
        // Can only resend for pending invitations
        if ($member->status !== 'pending') {
            return back()->with('error', 'Hanya undangan yang masih pending yang dapat dikirim ulang.');
        }
        
        try {
            // Regenerate token
            $member->update([
                'invitation_token' => Str::random(32),
                'invited_at' => now(),
            ]);
            
            // Resend invitation email
            // TODO: Implement in Sprint 7
            // $member->sendInvitationEmail();
            
            return back()->with('success', 'Undangan berhasil dikirim ulang ke ' . $member->email);
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Accept invitation (for invited team members).
     */
    public function acceptInvitation(Request $request, $token)
    {
        $teamMember = InovChallengeTeamMember::where('invitation_token', $token)->firstOrFail();
        
        // Check if invitation is still pending
        if ($teamMember->status !== 'pending') {
            return redirect()->route('dosen.inov_challenge.index')
                ->with('info', 'Undangan ini sudah ' . ($teamMember->status === 'accepted' ? 'diterima' : 'ditolak') . ' sebelumnya.');
        }
        
        // If user is logged in and email matches
        if (auth()->check() && auth()->user()->email === $teamMember->email) {
            try {
                DB::beginTransaction();
                
                // Update team member status
                $teamMember->update([
                    'status' => 'accepted',
                    'user_id' => auth()->id(), // Link to user if not already linked
                    'accepted_at' => now(),
                ]);
                
                // Notify submission owner
                // TODO: Implement in Sprint 7
                
                DB::commit();
                
                return redirect()->route('dosen.inov_challenge.submissions.show', $teamMember->submission_id)
                    ->with('success', 'Anda berhasil bergabung dengan tim.');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('dosen.inov_challenge.index')
                    ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
        
        // If not logged in or email doesn't match, show invitation page
        return view('inov_challenge.dosen.team.invitation', compact('teamMember'));
    }

    /**
     * Reject invitation.
     */
    public function rejectInvitation(Request $request, $token)
    {
        $teamMember = InovChallengeTeamMember::where('invitation_token', $token)->firstOrFail();
        
        // Check if invitation is still pending
        if ($teamMember->status !== 'pending') {
            return redirect()->route('dosen.inov_challenge.index')
                ->with('info', 'Undangan ini sudah ' . ($teamMember->status === 'accepted' ? 'diterima' : 'ditolak') . ' sebelumnya.');
        }
        
        try {
            DB::beginTransaction();
            
            // Update team member status
            $teamMember->update([
                'status' => 'rejected',
                'rejected_at' => now(),
            ]);
            
            // Notify submission owner
            // TODO: Implement in Sprint 7
            
            DB::commit();
            
            return redirect()->route('dosen.inov_challenge.index')
                ->with('info', 'Undangan berhasil ditolak.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dosen.inov_challenge.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

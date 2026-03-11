<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSubmission;
use App\Models\InovChalengeSubmissionMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Add a team member.
     */
    public function store(Request $request, InovChalengeSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $tipeOptions = implode(',', InovChalengeSubmissionMember::TIPE_OPTIONS);
        $peranIcOptions = implode(',', InovChalengeSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'tipe_anggota'      => "required|in:{$tipeOptions}",
            'nama_lengkap'      => 'required|string|max:255',
            'nik_nim_nip'       => 'required|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'user_id'           => 'nullable|exists:users,id',
            'peran_ic'          => "required|in:{$peranIcOptions}",
            'deskripsi_peran'   => 'required|string|max:1000',
        ]);

        // Check max member limit
        $session = $submission->session;
        if ($session->max_anggota) {
            $currentCount = $submission->members()->count();
            if ($currentCount >= $session->max_anggota) {
                return back()->with('error', "Jumlah anggota sudah mencapai batas maksimal ({$session->max_anggota}).");
            }
        }

        // Set approval status based on type
        $approvalStatus = InovChalengeSubmissionMember::defaultApprovalStatus($validated['tipe_anggota']);

        // If user_id provided for dosen/alumni, verify the user exists and pre-fill data from profile
        if (!empty($validated['user_id'])) {
            // Check if this user is already a member of any submission in the same session
            $alreadyInSession = InovChalengeSubmissionMember::where('user_id', $validated['user_id'])
                ->whereHas('submission', fn($q) => $q->where('inov_chalenge_session_id', $session->id))
                ->exists();

            if ($alreadyInSession) {
                return back()->with('error', 'User ini sudah terdaftar di tim lain pada sesi yang sama.');
            }

            $user = User::with('profile.fakultas', 'profile.prodi')->find($validated['user_id']);
            if ($user) {
                $validated['nama_lengkap'] = $user->name;
                // Auto-fill identifier from profile if not provided
                if (empty($validated['nik_nim_nip']) && $user->profile?->identifier_number) {
                    $validated['nik_nim_nip'] = $user->profile->identifier_number;
                }
                // Auto-fill fakultas from profile if not provided
                if (empty($validated['institusi_fakultas']) && $user->profile?->fakultas) {
                    $fakName = $user->profile->fakultas->name;
                    $prodiName = $user->profile->prodi?->name;
                    $validated['institusi_fakultas'] = $prodiName ? "{$fakName} / {$prodiName}" : $fakName;
                }
            }
        }

        $submission->members()->create([
            'user_id'           => $validated['user_id'] ?? null,
            'peran'             => 'Anggota',
            'peran_ic'          => $validated['peran_ic'],
            'deskripsi_peran'   => $validated['deskripsi_peran'],
            'tipe_anggota'      => $validated['tipe_anggota'],
            'nama_lengkap'      => $validated['nama_lengkap'],
            'nik_nim_nip'       => $validated['nik_nim_nip'] ?? null,
            'institusi_fakultas' => $validated['institusi_fakultas'] ?? null,
            'approval_status'   => $approvalStatus,
        ]);

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Update a team member.
     */
    public function update(Request $request, InovChalengeSubmission $submission, InovChalengeSubmissionMember $member)
    {
        abort_if($submission->user_id !== Auth::id(), 403);
        abort_if($member->inov_chalenge_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat diubah.');

        $peranIcOptions = implode(',', InovChalengeSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'nik_nim_nip'       => 'nullable|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'peran_ic'          => "required|in:{$peranIcOptions}",
            'deskripsi_peran'   => 'required|string|max:1000',
        ]);

        $member->update($validated);

        return back()->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove a team member (cannot remove Ketua).
     */
    public function destroy(InovChalengeSubmission $submission, InovChalengeSubmissionMember $member)
    {
        abort_if($submission->user_id !== Auth::id(), 403);
        abort_if($member->inov_chalenge_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat dihapus.');

        $member->delete();

        return back()->with('success', 'Anggota berhasil dihapus.');
    }

    /**
     * Search users by name/email for adding as members (AJAX).
     * Only searches for types that have system accounts (dosen, alumni).
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');
        $type = $request->get('type', 'dosen');

        // Only allow searching for types that exist in the users table
        if (!in_array($type, InovChalengeSubmissionMember::TIPE_SEARCHABLE)) {
            return response()->json([]);
        }

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Map member tipe to user role (handles DUDI→dudi, PPPK→pppk case difference)
        $role = InovChalengeSubmissionMember::TIPE_TO_ROLE[$type] ?? $type;

        $users = User::where('role', $role)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%");
            })
            ->with(['profile.fakultas', 'profile.prodi'])
            ->select('id', 'name', 'email')
            ->limit(10)
            ->get()
            ->map(function ($user) {
                return [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'identifier_number' => $user->profile?->identifier_number ?? '',
                    'fakultas'          => $user->profile?->fakultas?->name ?? '',
                    'prodi'             => $user->profile?->prodi?->name ?? '',
                    'institusi'         => $user->profile?->institusi ?? '',
                ];
            });

        return response()->json($users);
    }
}

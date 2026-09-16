<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Models\HackatonSubmission;
use App\Models\HackatonSubmissionMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Add a team member.
     */
    public function store(Request $request, HackatonSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $tipeOptions = implode(',', HackatonSubmissionMember::TIPE_OPTIONS);
        $peranIcOptions = implode(',', HackatonSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'tipe_anggota'       => "required|in:{$tipeOptions}",
            'nama_lengkap'       => 'required|string|max:255',
            'nik_nim_nip'        => 'required|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'user_id'            => 'nullable|exists:users,id',
            'peran_ic'           => "required|in:{$peranIcOptions}",
            'deskripsi_peran'    => 'required|string|max:1000',
        ]);

        $session = $submission->session;
        if ($session->max_anggota) {
            $currentCount = $submission->members()->count();
            if ($currentCount >= $session->max_anggota) {
                return back()->with('error', "Jumlah anggota sudah mencapai batas maksimal ({$session->max_anggota}).");
            }
        }

        $approvalStatus = HackatonSubmissionMember::defaultApprovalStatus($validated['tipe_anggota']);

        if (!empty($validated['user_id'])) {
            $alreadyInSubmission = HackatonSubmissionMember::where('user_id', $validated['user_id'])
                ->where('hackaton_submission_id', $submission->id)
                ->exists();

            if ($alreadyInSubmission) {
                return back()->with('error', 'User ini sudah terdaftar di tim ini.');
            }

            $user = User::with('profile.fakultas', 'profile.prodi')->find($validated['user_id']);
            if ($user) {
                $validated['nama_lengkap'] = $user->name;
                if (empty($validated['nik_nim_nip']) && $user->profile?->identifier_number) {
                    $validated['nik_nim_nip'] = $user->profile->identifier_number;
                }
                if (empty($validated['institusi_fakultas']) && $user->profile?->fakultas) {
                    $fakName = $user->profile->fakultas->name;
                    $prodiName = $user->profile->prodi?->name;
                    $validated['institusi_fakultas'] = $prodiName ? "{$fakName} / {$prodiName}" : $fakName;
                }
            }
        }

        $submission->members()->create([
            'user_id'            => $validated['user_id'] ?? null,
            'peran'              => 'Anggota',
            'peran_ic'           => $validated['peran_ic'],
            'deskripsi_peran'    => $validated['deskripsi_peran'],
            'tipe_anggota'       => $validated['tipe_anggota'],
            'nama_lengkap'       => $validated['nama_lengkap'],
            'nik_nim_nip'        => $validated['nik_nim_nip'] ?? null,
            'institusi_fakultas' => $validated['institusi_fakultas'] ?? null,
            'approval_status'    => $approvalStatus,
        ]);

        return back()->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    /**
     * Update a team member.
     */
    public function update(Request $request, HackatonSubmission $submission, HackatonSubmissionMember $member)
    {
        abort_if($submission->user_id !== Auth::id(), 403);
        abort_if($member->hackaton_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat diubah.');
        abort_if($member->approval_status === 'approved', 403, 'Anggota yang sudah disetujui hanya dapat diubah oleh Admin.');

        $peranIcOptions = implode(',', HackatonSubmissionMember::PERAN_IC_OPTIONS);

        $validated = $request->validate([
            'nama_lengkap'       => 'required|string|max:255',
            'nik_nim_nip'        => 'required|string|max:100',
            'institusi_fakultas' => 'nullable|string|max:255',
            'peran_ic'           => "required|in:{$peranIcOptions}",
            'deskripsi_peran'    => 'required|string|max:1000',
        ]);

        $member->update($validated);

        return back()->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    /**
     * Remove a team member.
     */
    public function destroy(HackatonSubmission $submission, HackatonSubmissionMember $member)
    {
        abort_if($submission->user_id !== Auth::id(), 403);
        abort_if($member->hackaton_submission_id !== $submission->id, 404);
        abort_if($member->peran === 'Ketua', 403, 'Ketua tidak dapat dihapus.');
        abort_if($member->approval_status === 'approved', 403, 'Anggota yang sudah disetujui hanya dapat dihapus oleh Admin.');

        $nama = $member->nama_lengkap;
        $member->delete();

        return back()->with('success', "Anggota tim {$nama} berhasil dihapus.");
    }

    /**
     * Search users matching hackaton roles.
     */
    public function searchUsers(Request $request)
    {
        $q = $request->query('q', '');
        $tipe = $request->query('tipe', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $targetRole = HackatonSubmissionMember::TIPE_TO_ROLE[$tipe] ?? null;

        $query = User::with('profile.fakultas', 'profile.prodi')
            ->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });

        if ($targetRole) {
            $possibleRoles = array_unique(array_filter([$targetRole, strtolower($tipe), 'hackaton_' . strtolower($tipe)]));
            $query->whereIn('role', $possibleRoles);
        }

        $users = $query->limit(10)->get()->map(function ($u) {
            $institusi = null;
            if ($u->profile?->fakultas) {
                $institusi = $u->profile->fakultas->name;
                if ($u->profile->prodi) {
                    $institusi .= ' / ' . $u->profile->prodi->name;
                }
            } elseif ($u->profile?->institusi) {
                $institusi = $u->profile->institusi;
            }

            return [
                'id'                 => $u->id,
                'name'               => $u->name,
                'email'              => $u->email,
                'role'               => $u->role,
                'identifier_number'  => $u->profile?->identifier_number,
                'institusi_fakultas' => $institusi,
            ];
        });

        return response()->json($users);
    }
}

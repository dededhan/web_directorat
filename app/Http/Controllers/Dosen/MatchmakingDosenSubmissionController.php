<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\MatchmakingMember;
use App\Models\MatchmakingSession;
use App\Models\MatchmakingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Monarobase\CountryList\CountryListFacade as Countries;

class MatchmakingDosenSubmissionController extends Controller
{

    public function store(Request $request, $sessionId)
    {
        $validated = $request->validate([
            'judul_proposal' => 'required|string|max:255',
            'members' => 'required|array|min:1',
            'members.*.type' => 'required|in:unj,international',
        ]);

        $session = MatchmakingSession::findOrFail($sessionId);

        DB::beginTransaction();
        try {
            $submission = MatchmakingSubmission::create([
                'matchmaking_session_id' => $session->id,
                'user_id' => Auth::id(),
                'judul_proposal' => $validated['judul_proposal'],
                'status' => 'diajukan',
            ]);

            $this->syncMembers($request, $submission);

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                ->with('success', 'Proposal berhasil diajukan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mengajukan proposal matchmaking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat mengajukan proposal.')->withInput();
        }
    }


    public function edit(MatchmakingSubmission $submission)
    {

        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }


        if ($submission->status !== 'diajukan') {
            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                             ->with('error', 'Proposal tidak dapat diedit lagi.');
        }

        $submission->load('members.user');
        $countriesList = Countries::getList('en', 'php');
        $formattedCountries = [];
        foreach ($countriesList as $code => $name) {
            $formattedCountries[] = ['code' => $code, 'name' => $name];
        }

        return view('subdirektorat-inovasi.dosen.matchresearch.form-edit-pengajuan', [
            'submission' => $submission,
            'countries' => $formattedCountries
        ]);
    }


    public function update(Request $request, MatchmakingSubmission $submission)
    {

        if ($submission->user_id !== Auth::id() || $submission->status !== 'diajukan') {
             return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                             ->with('error', 'Proposal tidak dapat diedit.');
        }

        $validated = $request->validate([
            'judul_proposal' => 'required|string|max:255',
            'members' => 'required|array|min:1',
            'members.*.type' => 'required|in:unj,international',
        ]);
        
        DB::beginTransaction();
        try {
            $submission->update(['judul_proposal' => $validated['judul_proposal']]);


            foreach ($submission->members as $member) {
                if ($member->type === 'international' && !empty($member->details['membership_proof'])) {
                    Storage::disk('public')->delete($member->details['membership_proof']);
                }
            }
            $submission->members()->delete();


            $this->syncMembers($request, $submission);

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                ->with('success', 'Proposal berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui proposal matchmaking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui proposal.')->withInput();
        }
    }


    private function syncMembers(Request $request, MatchmakingSubmission $submission)
    {
        foreach ($request->input('members', []) as $index => $memberData) {
            if ($memberData['type'] === 'unj') {
                MatchmakingMember::create([
                    'matchmaking_submission_id' => $submission->id,
                    'type' => 'unj',
                    'user_id' => $memberData['user_id'] ?? null,
                ]);
            } elseif ($memberData['type'] === 'international') {
                $details = $memberData[$memberData['international_type']] ?? [];
                
                $fileFields = ['fellow' => 'membership_proof', 'academy' => 'membership_proof'];
                if (isset($fileFields[$memberData['international_type']])) {
                    $fileField = $fileFields[$memberData['international_type']];
                    $fileInputName = "members.{$index}.{$memberData['international_type']}.{$fileField}";

                    if ($request->hasFile($fileInputName)) {
                        $path = $request->file($fileInputName)->store('matchmaking_proofs', 'public');
                        $details[$fileField] = $path;
                    }
                }

                MatchmakingMember::create([
                    'matchmaking_submission_id' => $submission->id,
                    'type' => 'international',
                    'user_id' => null,
                    'details' => $details,
                ]);
            }
        }
    }
}

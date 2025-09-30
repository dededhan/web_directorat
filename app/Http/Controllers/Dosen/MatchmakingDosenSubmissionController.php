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
use Illuminate\Support\Str;
use Carbon\Carbon;

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

                        $submission->addStatusLog('diajukan', 'Proposal berhasil dibuat dan diajukan oleh dosen.');

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


        if ($submission->status !== 'diajukan' && $submission->status !== 'revisi' ) { 
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

        if ($submission->user_id !== Auth::id() || !in_array($submission->status, ['diajukan', 'revisi'])) {
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

            $newStatus = $submission->status === 'revisi' ? 'diajukan' : $submission->status;
            $submission->update([
                'judul_proposal' => $validated['judul_proposal'],
                'status' => $newStatus,
            ]);


            $existingMemberIds = [];
            foreach($request->input('members', []) as $memberData) {
                if(!empty($memberData['id'])) {
                    $existingMemberIds[] = $memberData['id'];
                }
            }


            $membersToDelete = $submission->members()->whereNotIn('id', $existingMemberIds)->get();
            foreach($membersToDelete as $member) {
                 if ($member->type === 'international' && !empty($member->details['membership_proof'])) {
                    Storage::disk('public')->delete($member->details['membership_proof']);
                }
                if ($member->type === 'international' && !empty($member->details['partner_availability_letter'])) {
                    Storage::disk('public')->delete($member->details['partner_availability_letter']);
                }
                $member->delete();
            }

            $this->syncMembers($request, $submission, true);

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.matchresearch.manajemen')
                ->with('success', 'Proposal berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui proposal matchmaking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui proposal.')->withInput();
        }
    }


    private function syncMembers(Request $request, MatchmakingSubmission $submission, $isUpdate = false)
    {
        $proposerName = Str::slug(Auth::user()->name, '_');

        foreach ($request->input('members', []) as $index => $memberData) {
            $memberId = $memberData['id'] ?? null;
            $member = null;


            if ($isUpdate && $memberId) {
                $member = MatchmakingMember::find($memberId);
            }

            if ($memberData['type'] === 'unj') {
                $data = [
                    'matchmaking_submission_id' => $submission->id,
                    'type' => 'unj',
                    'user_id' => $memberData['user_id'] ?? null,
                    'details' => null 
                ];
                 if ($member) $member->update($data);
                 else MatchmakingMember::create($data);

            } elseif ($memberData['type'] === 'international') {
                $internationalType = $memberData['international_type'] ?? null;
                
     
                $details = $internationalType ? ($memberData[$internationalType] ?? []) : [];
                $details['international_type'] = $internationalType; 
                
                if ($internationalType === 'academy') {
                    $yearStart = $details['membership_year_start'] ?? null;
                    $yearEnd = $details['membership_year_end'] ?? null;

                    if ($yearStart && $yearEnd) {
                        $details['membership_year_range'] = "{$yearStart} - {$yearEnd}";
                    }
                    
                    unset($details['membership_year_start'], $details['membership_year_end']);
                }

                $fileFieldsConfig = [
                    'fellow' => ['membership_proof', 'partner_availability_letter'],
                    'academy' => ['membership_proof', 'partner_availability_letter'],
                    'h_index' => ['partner_availability_letter'],
                    'editor' => ['partner_availability_letter'],
                ];

                if ($internationalType && isset($fileFieldsConfig[$internationalType])) {
                    $fileFields = $fileFieldsConfig[$internationalType];

                    foreach($fileFields as $fileField) {
                        $fileInputName = "members.{$index}.{$internationalType}.{$fileField}";
                        
                        $oldFilePath = $member ? ($member->details[$fileField] ?? null) : null;

                        if ($request->hasFile($fileInputName)) {
                            if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
                                Storage::disk('public')->delete($oldFilePath);
                            }
                            
                            $file = $request->file($fileInputName);
                            $extension = $file->getClientOriginalExtension();

                            $filename = "{$proposerName}_{$fileField}.{$extension}";

                            $path = $file->storeAs("matchmaking_proofs/{$submission->id}", $filename, 'public');
                            $details[$fileField] = $path;
                        } else {
    
                             if (isset($member->details[$fileField])) {
                                $details[$fileField] = $member->details[$fileField];
                            }
                        }
                    }
                }
                
                $data = [
                    'matchmaking_submission_id' => $submission->id,
                    'type' => 'international',
                    'user_id' => null,
                    'details' => $details,
                ];
                
                if ($member) $member->update($data);
                else MatchmakingMember::create($data);
            }
        }
    }
}

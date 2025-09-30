<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ApcSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApcSubmissionAdminController extends Controller
{
    public function show(ApcSubmission $submission)
    {
        $submission->load(['session', 'authors', 'user']);
        return view('admin_equity.apc.submission-detail', compact('submission'));
    }

    public function updateStatus(Request $request, ApcSubmission $submission)
    {

        $validated = $request->validate([

            'status' => [
                'required',
                Rule::in(['diajukan', 'verifikasi', 'disetujui', 'ditolak', 'revisi', 'verifikasi pembayaran', 'selesai']),
            ],
            'catatan_revisi' => [
                Rule::requiredIf($request->status === 'revisi'),
                'nullable',
                'string',
                'min:10',
            ],
        ], [
            'catatan_revisi.required' => 'Catatan revisi wajib diisi jika status diubah menjadi "Revisi".'
        ]);

        $oldStatus = $submission->status;
        $newStatus = $validated['status'];


        $updateData = [
            'status' => $newStatus,
        ];

        if ($newStatus === 'revisi') {
            $updateData['catatan_revisi'] = $validated['catatan_revisi'];
            $notes = "Status diubah oleh admin: " . Auth::user()->name . ". Catatan: " . $validated['catatan_revisi'];
        } else {
 
            $updateData['catatan_revisi'] = null;
            $notes = "Status diubah oleh admin: " . Auth::user()->name . ".";
        }
        

        if ($oldStatus !== $newStatus) {
            $submission->update($updateData);
            $submission->addStatusLog($newStatus, $notes);
        }


        return redirect()->route('admin_equity.apc.submission.show', $submission->id)
                         ->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}
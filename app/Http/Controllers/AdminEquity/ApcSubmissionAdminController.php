<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ApcSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'status' => 'required|in:diajukan,verifikasi,disetujui,ditolak',
        ]);

        $oldStatus = $submission->status;
        $newStatus = $validated['status'];

        if ($oldStatus !== $newStatus) {
            $submission->update(['status' => $newStatus]);
            $adminName = Auth::user()->name;
            $submission->addStatusLog($newStatus, "Status diubah oleh admin: {$adminName}.");
        }

        return redirect()->route('admin_equity.apc.submission.show', $submission->id)
                         ->with('success', 'Status pengajuan berhasil diperbarui!');
    }
}


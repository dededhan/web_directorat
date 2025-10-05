<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\JointSupervisionSubmission; // <-- Ganti Model
use Illuminate\Http\Request;

class JointSupervisionManagementController extends Controller
{
    /**
     * Menampilkan semua proposal Joint Supervision untuk diverifikasi.
     */
    public function index()
    {
        $submissions = JointSupervisionSubmission::with('user.profile.fakultas')->latest()->paginate(10);
        // Pastikan Anda membuat folder view 'joint_supervision' di dalam 'admin_equity'
        return view('admin_equity.joint_supervision.index', compact('submissions'));
    }

    /**
     * Menampilkan detail satu proposal.
     */
    public function show(JointSupervisionSubmission $submission)
    {
        $submission->load('user.profile.fakultas');
        return view('admin_equity.joint_supervision.show', compact('submission'));
    }

    /**
     * Mengubah status proposal.
     */
    public function updateStatus(Request $request, JointSupervisionSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $submission->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin_equity.joint-supervision.index')->with('success', 'Status proposal berhasil diubah.');
    }
}
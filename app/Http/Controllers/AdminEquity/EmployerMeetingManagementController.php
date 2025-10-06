<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\EmployerMeetingSubmission; // <-- Ganti Model
use Illuminate\Http\Request;

class EmployerMeetingManagementController extends Controller
{
    /**
     * Menampilkan semua proposal Employer Meeting untuk diverifikasi.
     */
    public function index()
    {
        $submissions = EmployerMeetingSubmission::with('user.profile.fakultas')->latest()->paginate(10);
        // Pastikan Anda membuat folder view 'employer_meetings' di dalam 'admin_equity'
        return view('admin_equity.employer_meetings.index', compact('submissions'));
    }

    /**
     * Menampilkan detail satu proposal.
     */
    public function show(EmployerMeetingSubmission $submission)
    {
        $submission->load('user.profile.fakultas');
        return view('admin_equity.employer_meetings.show', compact('submission'));
    }

    /**
     * Mengubah status proposal.
     */
    public function updateStatus(Request $request, EmployerMeetingSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $submission->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin_equity.employer-meetings.index')->with('success', 'Status proposal berhasil diubah.');
    }
}
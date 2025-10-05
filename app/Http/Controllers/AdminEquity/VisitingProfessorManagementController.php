<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\VisitingProfessorSubmission;
use Illuminate\Http\Request;

class VisitingProfessorManagementController extends Controller
{
    // Menampilkan semua proposal untuk diverifikasi
    public function index()
    {
        $submissions = VisitingProfessorSubmission::with('user.profile.fakultas')->latest()->paginate(10);
        return view('admin_equity.visiting_professor.index', compact('submissions'));
    }

    // Menampilkan detail satu proposal
    public function show(VisitingProfessorSubmission $submission)
    {
        $submission->load('user.profile.fakultas');
        return view('admin_equity.visiting_professor.show', compact('submission'));
    }

    // Mengubah status proposal
    public function updateStatus(Request $request, VisitingProfessorSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $submission->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin_equity.visiting-professors.index')->with('success', 'Status proposal berhasil diubah.');
    }
}
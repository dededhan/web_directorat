<?php

namespace App\Http\Controllers\EquityFakultas;

use App\Http\Controllers\Controller;
use App\Models\EmployerMeetingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployerMeetingController extends Controller
{
    public function index()
    {
        $submissions = EmployerMeetingSubmission::where('user_id', Auth::id())->latest()->paginate(10);
        return view('equity_fakultas.employer_meetings.index', compact('submissions'));
    }

    public function create()
    {
        return view('equity_fakultas.employer_meetings.create');
    }

    /**
     * Menyimpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $path = $request->file('proposal_file')->store('proposals/employer_meetings', 'public');

        EmployerMeetingSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal Employer Meeting berhasil diajukan.');
    }

    /**
     * Menampilkan form untuk melengkapi data (setelah disetujui admin).
     */
    public function edit(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->status !== 'disetujui') {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.employer_meetings.edit', ['submission' => $employerMeeting]);
    }

    /**
     * Menyimpan data tambahan (bukti keuangan & nama responden).
     */
    public function update(Request $request, EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->status !== 'disetujui') {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'bukti_keuangan_file' => 'required|file|mimes:pdf|max:2048',
            'nama_calon_responden' => 'required|string|max:1000', // Validasi field tambahan
        ]);
        
        if ($employerMeeting->bukti_keuangan_path) {
            Storage::disk('public')->delete($employerMeeting->bukti_keuangan_path);
        }

        $path = $request->file('bukti_keuangan_file')->store('bukti_keuangan/employer_meetings', 'public');

        $employerMeeting->update([
            'bukti_keuangan_path' => $path,
            'nama_calon_responden' => $request->nama_calon_responden, // Simpan data tambahan
            'status' => 'selesai',
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Data proposal berhasil dilengkapi.');
    }
}
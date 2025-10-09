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
     * Menampilkan detail proposal
     */
    public function show(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.employer_meetings.show', ['submission' => $employerMeeting]);
    }

    /**
     * Menyimpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf,xlsx,xls|max:2048',
        ]);

        $path = $request->file('proposal_file')->store('proposals/employer_meetings', 'public');

        EmployerMeetingSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
            'is_confirmed' => false,
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil diajukan. Silakan konfirmasi untuk mengirim ke admin.');
    }

    /**
     * Edit proposal yang masih dalam status diajukan (sebelum dikonfirmasi)
     */
    public function editDraft(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.employer_meetings.edit_draft', ['submission' => $employerMeeting]);
    }

    /**
     * Update proposal yang masih draft
     */
    public function updateDraft(Request $request, EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'nullable|file|mimes:pdf,xlsx,xls|max:2048',
        ]);

        $data = ['nama_pengunggah' => $request->nama_pengunggah];

        if ($request->hasFile('proposal_file')) {
            if ($employerMeeting->proposal_path) {
                Storage::disk('public')->delete($employerMeeting->proposal_path);
            }
            $data['proposal_path'] = $request->file('proposal_file')->store('proposals/employer_meetings', 'public');
        }

        $employerMeeting->update($data);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    /**
     * Hapus proposal yang masih draft
     */
    public function destroy(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        if ($employerMeeting->proposal_path) {
            Storage::disk('public')->delete($employerMeeting->proposal_path);
        }

        $employerMeeting->delete();

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil dihapus.');
    }

    /**
     * Konfirmasi pengajuan untuk dikirim ke admin
     */
    public function confirm(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $employerMeeting->update([
            'is_confirmed' => true,
            'status' => 'menunggu diverifikasi',
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil dikirim dan menunggu verifikasi admin.');
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
            'laporan_kegiatan_file' => 'required|file|mimes:pdf|max:2048',
            'nama_qs_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ]);
        
        if ($employerMeeting->bukti_keuangan_path) {
            Storage::disk('public')->delete($employerMeeting->bukti_keuangan_path);
        }
        if ($employerMeeting->laporan_kegiatan_path) {
            Storage::disk('public')->delete($employerMeeting->laporan_kegiatan_path);
        }
        if ($employerMeeting->nama_qs_path) {
            Storage::disk('public')->delete($employerMeeting->nama_qs_path);
        }

        $buktiPath = $request->file('bukti_keuangan_file')->store('bukti_keuangan/employer_meetings', 'public');
        $laporanPath = $request->file('laporan_kegiatan_file')->store('laporan_kegiatan/employer_meetings', 'public');
        $qsPath = $request->file('nama_qs_file')->store('nama_qs/employer_meetings', 'public');

        $employerMeeting->update([
            'bukti_keuangan_path' => $buktiPath,
            'laporan_kegiatan_path' => $laporanPath,
            'nama_qs_path' => $qsPath,
            'status' => 'selesai',
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Data proposal berhasil dilengkapi.');
    }
}
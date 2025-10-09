<?php

namespace App\Http\Controllers\EquityFakultas;

use App\Http\Controllers\Controller;
use App\Models\VisitingProfessorSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VisitingProfessorController extends Controller
{
    // Menampilkan daftar proposal yang diajukan oleh fakultas yang login
    public function index()
    {
        $submissions = VisitingProfessorSubmission::where('user_id', Auth::id())->latest()->paginate(10);
        return view('equity_fakultas.visiting_professor.index', compact('submissions'));
    }

    // Menampilkan form untuk membuat pengajuan baru
    public function create()
    {
        return view('equity_fakultas.visiting_professor.create');
    }

    public function show(VisitingProfessorSubmission $visitingProfessor)
    {
        if ($visitingProfessor->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.visiting_professor.show', ['submission' => $visitingProfessor]);
    }

    // Menyimpan pengajuan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf,xlsx,xls|max:2048',
        ]);

        $path = $request->file('proposal_file')->store('proposals/visiting_professor', 'public');

        VisitingProfessorSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
            'is_confirmed' => false,
        ]);

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Proposal berhasil diajukan. Silakan konfirmasi untuk mengirim ke admin.');
    }

    public function editDraft(VisitingProfessorSubmission $visitingProfessor)
    {
        if ($visitingProfessor->user_id !== Auth::id() || $visitingProfessor->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.visiting_professor.edit_draft', ['submission' => $visitingProfessor]);
    }

    public function updateDraft(Request $request, VisitingProfessorSubmission $visitingProfessor)
    {
        if ($visitingProfessor->user_id !== Auth::id() || $visitingProfessor->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'nullable|file|mimes:pdf,xlsx,xls|max:2048',
        ]);

        $data = ['nama_pengunggah' => $request->nama_pengunggah];

        if ($request->hasFile('proposal_file')) {
            if ($visitingProfessor->proposal_path) {
                Storage::disk('public')->delete($visitingProfessor->proposal_path);
            }
            $data['proposal_path'] = $request->file('proposal_file')->store('proposals/visiting_professor', 'public');
        }

        $visitingProfessor->update($data);

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    public function destroy(VisitingProfessorSubmission $visitingProfessor)
    {
        if ($visitingProfessor->user_id !== Auth::id() || $visitingProfessor->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        if ($visitingProfessor->proposal_path) {
            Storage::disk('public')->delete($visitingProfessor->proposal_path);
        }

        $visitingProfessor->delete();

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Proposal berhasil dihapus.');
    }

    public function confirm(VisitingProfessorSubmission $visitingProfessor)
    {
        if ($visitingProfessor->user_id !== Auth::id() || $visitingProfessor->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $visitingProfessor->update([
            'is_confirmed' => true,
            'status' => 'menunggu diverifikasi',
        ]);

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Proposal berhasil dikirim dan menunggu verifikasi admin.');
    }

    // Menampilkan form untuk melengkapi data (setelah disetujui admin)
    public function edit(VisitingProfessorSubmission $visitingProfessor)
    {
        // Pastikan hanya pemilik yang bisa edit & statusnya 'disetujui'
        if ($visitingProfessor->user_id !== Auth::id() || $visitingProfessor->status !== 'disetujui') {
            abort(403);
        }
        return view('equity_fakultas.visiting_professor.edit', ['submission' => $visitingProfessor]);
    }

    // Menyimpan data tambahan (bukti keuangan, dll)
    public function update(Request $request, VisitingProfessorSubmission $visitingProfessor)
    {
        if ($visitingProfessor->user_id !== Auth::id() || $visitingProfessor->status !== 'disetujui') {
            abort(403);
        }

        $request->validate([
            'bukti_keuangan_file' => 'required|file|mimes:pdf|max:2048',
            'laporan_kegiatan_file' => 'required|file|mimes:pdf|max:2048',
        ]);
        
        if ($visitingProfessor->bukti_keuangan_path) {
            Storage::disk('public')->delete($visitingProfessor->bukti_keuangan_path);
        }
        if ($visitingProfessor->laporan_kegiatan_path) {
            Storage::disk('public')->delete($visitingProfessor->laporan_kegiatan_path);
        }

        $buktiPath = $request->file('bukti_keuangan_file')->store('bukti_keuangan/visiting_professor', 'public');
        $laporanPath = $request->file('laporan_kegiatan_file')->store('laporan_kegiatan/visiting_professor', 'public');

        $visitingProfessor->update([
            'bukti_keuangan_path' => $buktiPath,
            'laporan_kegiatan_path' => $laporanPath,
            'status' => 'selesai',
        ]);

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Data berhasil dilengkapi.');
    }
}
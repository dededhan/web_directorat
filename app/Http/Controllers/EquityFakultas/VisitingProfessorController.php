<?php

namespace App\Http\Controllers\EquityFakultas;

use App\Http\Controllers\Controller;
use App\Models\VisitingProfessorSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Menyimpan pengajuan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf|max:2048', // Contoh validasi file
        ]);

        $path = $request->file('proposal_file')->store('proposals/visiting_professor', 'public');

        VisitingProfessorSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
        ]);

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Proposal berhasil diajukan.');
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
        ]);
        
        $path = $request->file('bukti_keuangan_file')->store('bukti_keuangan/visiting_professor', 'public');

        $visitingProfessor->update([
            'bukti_keuangan_path' => $path,
            'status' => 'selesai', // Ubah status menjadi selesai
        ]);

        return redirect()->route('equity_fakultas.visiting-professors.index')->with('success', 'Data berhasil dilengkapi.');
    }
}
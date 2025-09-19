<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ProposalSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProposalSessionController extends Controller
{
    
    // Menampilkan daftar semua sesi proposal
    public function index()
    {
        $sessions = ProposalSession::latest()->paginate(10);
        return view('admin.comdev.index', compact('sessions'));
    }

    // Menampilkan form untuk membuat sesi baru
    public function create()
    {
        return view('admin.comdev.create');
    }

    // Menyimpan data dari form create ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dana_maksimal' => 'required|numeric',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'required|integer|min:1',
            'max_anggota' => 'required|integer|gte:min_anggota',
        ]);

        ProposalSession::create($request->all());

        // DIUBAH: Mengarah ke halaman index dengan nama route yang benar
        return redirect()->route('admin.proposal-sessions.index')
                         ->with('success', 'Sesi proposal berhasil dibuat.');
    }
    public function getDetail(ProposalSession $proposalSession)
    {
        return response()->json($proposalSession);
    }


    // Menampilkan form untuk mengedit sesi
    public function edit(ProposalSession $proposalSession)
    {
        return view('admin.comdev.edit', ['session' => $proposalSession]);
    }

    // Mengupdate data di database
    public function update(Request $request, ProposalSession $proposalSession)
    {
        $validatedData = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'dana_maksimal' => 'required|numeric',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'required|integer|min:1',
            'max_anggota' => 'required|integer|gte:min_anggota',
        ]);

        $proposalSession->update($validatedData);

        // DIUBAH: Mengarah ke halaman index dengan nama route yang benar
        return redirect()->route('admin.proposal-sessions.index')
                         ->with('success', 'Sesi proposal berhasil diperbarui.');
    }

    // Menghapus data dari database
    public function destroy(ProposalSession $proposalSession)
    {
        $proposalSession->delete();
        // DIUBAH: Mengarah ke halaman index dengan nama route yang benar
        return redirect()->route('admin.proposal-sessions.index')
                         ->with('success', 'Sesi proposal berhasil dihapus.');
    }
}
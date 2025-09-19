<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComdevProposalController extends Controller 
{
    public function index()
    {
        // DIUBAH: Menggunakan model baru
        $sessions = ComdevProposal::latest()->paginate(10);
        return view('admin.comdev.index', compact('sessions'));
    }

    public function getDetail(ComdevProposal $proposalSession) 
    {
        return response()->json($proposalSession);
    }
    
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

        ComdevProposal::create($request->all()); 

        return redirect()->route('admin.proposal-sessions.index')
                         ->with('success', 'Sesi proposal berhasil dibuat.');
    }

    public function update(Request $request, ComdevProposal $proposalSession) 
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

        return redirect()->route('admin.proposal-sessions.index')
                         ->with('success', 'Sesi proposal berhasil diperbarui.');
    }

    public function destroy(ComdevProposal $proposalSession) 
    {
        $proposalSession->delete();
        return redirect()->route('admin.proposal-sessions.index')
                         ->with('success', 'Sesi proposal berhasil dihapus.');
    }
}
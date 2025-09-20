<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal; 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComdevProposalController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = ComdevProposal::latest()->paginate(10);
        // PASTIKAN PATH VIEW SUDAH BENAR
        return view('admin_equity.comdev.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan view untuk membuat sesi baru
        return view('admin_equity.comdev.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dana_maksimal' => 'required|numeric',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'required|integer|min:1',
            'max_anggota' => 'required|integer|gte:min_anggota',
        ]);

        ComdevProposal::create($request->all()); 

        return redirect()->route('admin_equity.comdev.index')
                         ->with('success', 'Sesi proposal berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComdevProposal $comdevproposal)
    {
        // Menampilkan detail satu sesi
        return view('admin_equity.comdev.show', ['session' => $comdevproposal]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComdevProposal $comdevproposal)
    {
        // Menampilkan view untuk mengedit sesi
        return view('admin_equity.comdev.edit', ['session' => $comdevproposal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComdevProposal $comdevproposal) 
    {
        $validatedData = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string', 
            'dana_maksimal' => 'required|numeric',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'required|integer|min:1',
            'max_anggota' => 'required|integer|gte:min_anggota',
        ]);

        $comdevproposal->update($validatedData);
            
        return redirect()->route('admin_equity.comdev.index')
                        ->with('success', 'Sesi proposal berhasil diperbarui.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComdevProposal $comdevproposal) 
    {
        $comdevproposal->delete();
        return redirect()->route('admin_equity.comdev.index')
                         ->with('success', 'Sesi proposal berhasil dihapus.');
    }
}

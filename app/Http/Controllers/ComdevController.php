<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal; 
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ComdevController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = ComdevProposal::latest()->paginate(10);
        return view('admin_equity.comdev.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
    public function show(ComdevProposal $comdev)
    {
        return view('admin_equity.comdev.show', ['session' => $comdev]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComdevProposal $comdev)
    {
        return view('admin_equity.comdev.edit', ['session' => $comdev]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComdevProposal $comdev) 
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

        $comdev->update($validatedData);
            
        return redirect()->route('admin_equity.comdev.index')
                        ->with('success', 'Sesi proposal berhasil diperbarui.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComdevProposal $comdev) 
    {
        $comdev->delete();
        return redirect()->route('admin_equity.comdev.index')
                         ->with('success', 'Sesi proposal berhasil dihapus.');
    }
}

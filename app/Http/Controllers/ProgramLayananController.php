<?php

namespace App\Http\Controllers;

use App\Models\ProgramLayanan;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProgramLayananRequest;

class ProgramLayananController extends Controller
{
    public function index()
    {
        $programs = ProgramLayanan::all();
        return view('admin.programlayanan', compact('programs'));
    }

    public function store(StoreProgramLayananRequest $request)
    {
        ProgramLayanan::create($request->validated());
        return redirect()->route('admin.program-layanan.index')->with('success', 'Program berhasil ditambahkan');
    }

    public function update(StoreProgramLayananRequest $request, ProgramLayanan $programLayanan)
    {
        $programLayanan->update($request->validated());
        return redirect()->route('admin.program-layanan.index')->with('success', 'Program berhasil diperbarui');
    }

    public function destroy(ProgramLayanan $programLayanan)
    {
        $programLayanan->delete();
        return redirect()->route('admin.program-layanan.index')->with('success', 'Program berhasil dihapus');
    }
    
    /**
     * Display active program layanan on the frontend
     */
    public function showFrontend()
    {
        // Get active program layanan, limit to 4 for display
        $programs = ProgramLayanan::where('status', 1)
                                  ->orderBy('id', 'desc')
                                  ->take(4)
                                  ->get();
        
        return view('frontend.program-section', compact('programs'));
    }
}
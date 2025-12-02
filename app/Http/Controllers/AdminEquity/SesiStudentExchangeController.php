<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\SesiStudentExchange;
use Illuminate\Http\Request;

class SesiStudentExchangeController extends Controller
{
    /**
     * Display a listing of all student exchange sessions.
     */
    public function index()
    {
        $sessions = SesiStudentExchange::withCount('proposals')->latest()->paginate(10);
        return view('admin_equity.student-exchange.sesi.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new session.
     */
    public function create()
    {
        return view('admin_equity.student-exchange.sesi.create');
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:dibuka,ditutup',
        ]);

        SesiStudentExchange::create($request->all());

        return redirect()->route('admin_equity.student_exchange.sesi.index')
            ->with('success', 'Sesi student exchange berhasil dibuat.');
    }

    /**
     * Display the specified session with proposals.
     */
    public function show(SesiStudentExchange $sesi)
    {
        $sesi->load(['proposals.user', 'proposals.anggota', 'proposals.mitra', 'moduls.subChapters']);
        return view('admin_equity.student-exchange.sesi.show', compact('sesi'));
    }

    /**
     * Show the form for editing the specified session.
     */
    public function edit(SesiStudentExchange $sesi)
    {
        return view('admin_equity.student-exchange.sesi.edit', compact('sesi'));
    }

    /**
     * Update the specified session in storage.
     */
    public function update(Request $request, SesiStudentExchange $sesi)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:dibuka,ditutup',
        ]);

        $sesi->update($request->all());

        return redirect()->route('admin_equity.student_exchange.sesi.index')
            ->with('success', 'Sesi student exchange berhasil diperbarui.');
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy(SesiStudentExchange $sesi)
    {
        $sesi->delete();
        
        return redirect()->route('admin_equity.student_exchange.sesi.index')
            ->with('success', 'Sesi student exchange berhasil dihapus.');
    }
}

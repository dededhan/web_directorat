<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\SesiHibahModul;
use Illuminate\Http\Request;

class SesiHibahModulController extends Controller
{
    public function index()
    {
        $sessions = SesiHibahModul::withCount('proposals')->latest()->paginate(10);
        return view('admin_equity.hibah_modul.sesi.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin_equity.hibah_modul.sesi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:dibuka,ditutup',
        ]);

        SesiHibahModul::create($request->all());

        return redirect()->route('admin_equity.hibah_modul.sesi.index')
            ->with('success', 'Sesi hibah modul berhasil dibuat.');
    }

    public function show(SesiHibahModul $sesi)
    {
        $sesi->load(['proposals.user', 'proposals.anggota', 'moduls.subChapters']);
        return view('admin_equity.hibah_modul.sesi.show', compact('sesi'));
    }

    public function edit(SesiHibahModul $sesi)
    {
        return view('admin_equity.hibah_modul.sesi.edit', compact('sesi'));
    }

    public function update(Request $request, SesiHibahModul $sesi)
    {
        $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'nominal_usulan' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:dibuka,ditutup',
        ]);

        $data = $request->all();
        if ($request->filled('nominal_usulan')) {
            $data['nominal_usulan'] = preg_replace('/[^0-9]/', '', $request->nominal_usulan);
        }

        $sesi->update($data);

        return redirect()->route('admin_equity.hibah_modul.sesi.index')
            ->with('success', 'Sesi hibah modul berhasil diperbarui.');
    }

    public function destroy(SesiHibahModul $sesi)
    {
        $sesi->delete();
        
        return redirect()->route('admin_equity.hibah_modul.sesi.index')
            ->with('success', 'Sesi hibah modul berhasil dihapus.');
    }
}

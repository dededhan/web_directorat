<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonSession;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = HackatonSession::withCount('submissions')
            ->latest()
            ->paginate(10);

        return view('admin_hackaton.sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin_hackaton.sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sesi'     => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'dana_minimal'  => 'nullable|numeric|min:0',
            'dana_maksimal' => 'nullable|numeric|min:0|gte:dana_minimal',
            'periode_awal'  => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota'   => 'nullable|integer|min:1',
            'max_anggota'   => 'nullable|integer|min:1|gte:min_anggota',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';

        $session = HackatonSession::create($validated);

        // Auto-seed 3 Tahap
        $tahapDefaults = [
            ['tahap_ke' => 1, 'nama_tahap' => 'Tahap 1', 'has_anggota' => true, 'has_fakultas' => true],
            ['tahap_ke' => 2, 'nama_tahap' => 'Tahap 2', 'has_anggota' => false, 'has_fakultas' => false],
            ['tahap_ke' => 3, 'nama_tahap' => 'Tahap 3', 'has_anggota' => false, 'has_fakultas' => false],
        ];

        foreach ($tahapDefaults as $tahap) {
            $session->tahap()->create($tahap);
        }

        return redirect()
            ->route('admin_hackaton.sessions.show', $session)
            ->with('success', 'Sesi Hackaton berhasil dibuat.');
    }

    public function show(HackatonSession $session)
    {
        $session->load(['tahap.fields', 'submissions']);

        return view('admin_hackaton.sessions.show', compact('session'));
    }

    public function edit(HackatonSession $session)
    {
        return view('admin_hackaton.sessions.edit', compact('session'));
    }

    public function update(Request $request, HackatonSession $session)
    {
        $validated = $request->validate([
            'nama_sesi'     => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
            'dana_minimal'  => 'nullable|numeric|min:0',
            'dana_maksimal' => 'nullable|numeric|min:0|gte:dana_minimal',
            'periode_awal'  => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota'   => 'nullable|integer|min:1',
            'max_anggota'   => 'nullable|integer|min:1|gte:min_anggota',
        ]);

        $session->update($validated);

        return redirect()
            ->route('admin_hackaton.sessions.show', $session)
            ->with('success', 'Sesi Hackaton berhasil diperbarui.');
    }

    public function destroy(HackatonSession $session)
    {
        $session->delete();

        return redirect()
            ->route('admin_hackaton.sessions.index')
            ->with('success', 'Sesi Hackaton berhasil dihapus.');
    }

    public function activate(HackatonSession $session)
    {
        $session->update(['status' => 'active']);

        return back()->with('success', 'Sesi Hackaton berhasil diaktifkan.');
    }

    public function close(HackatonSession $session)
    {
        $session->update(['status' => 'closed']);

        return back()->with('success', 'Sesi Hackaton berhasil ditutup.');
    }
}

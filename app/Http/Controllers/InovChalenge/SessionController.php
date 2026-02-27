<?php

namespace App\Http\Controllers\InovChalenge;

use App\Http\Controllers\Controller;
use App\Models\InovChalengeSession;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = InovChalengeSession::withCount('submissions')
            ->latest()
            ->paginate(10);

        return view('admin_inovasi.inovchalenge.sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('admin_inovasi.inovchalenge.sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dana_minimal' => 'nullable|numeric|min:0',
            'dana_maksimal' => 'nullable|numeric|min:0|gte:dana_minimal',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'nullable|integer|min:1',
            'max_anggota' => 'nullable|integer|min:1|gte:min_anggota',
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'draft';

        $session = InovChalengeSession::create($validated);

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
            ->route('admin_inovasi.inovchalenge.sessions.show', $session)
            ->with('success', 'Sesi berhasil dibuat dengan 3 tahap.');
    }

    public function show(InovChalengeSession $session)
    {
        $session->load(['tahap.fields', 'submissions']);

        return view('admin_inovasi.inovchalenge.sessions.show', compact('session'));
    }

    public function edit(InovChalengeSession $session)
    {
        return view('admin_inovasi.inovchalenge.sessions.edit', compact('session'));
    }

    public function update(Request $request, InovChalengeSession $session)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dana_minimal' => 'nullable|numeric|min:0',
            'dana_maksimal' => 'nullable|numeric|min:0|gte:dana_minimal',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'min_anggota' => 'nullable|integer|min:1',
            'max_anggota' => 'nullable|integer|min:1|gte:min_anggota',
        ]);

        $session->update($validated);

        return redirect()
            ->route('admin_inovasi.inovchalenge.sessions.show', $session)
            ->with('success', 'Sesi berhasil diperbarui.');
    }

    public function destroy(InovChalengeSession $session)
    {
        $session->delete();

        return redirect()
            ->route('admin_inovasi.inovchalenge.sessions.index')
            ->with('success', 'Sesi berhasil dihapus.');
    }

    public function activate(InovChalengeSession $session)
    {
        $session->update(['status' => 'active']);

        return back()->with('success', 'Sesi berhasil diaktifkan.');
    }

    public function close(InovChalengeSession $session)
    {
        $session->update(['status' => 'closed']);

        return back()->with('success', 'Sesi berhasil ditutup.');
    }
}

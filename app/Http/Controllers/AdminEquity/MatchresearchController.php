<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\MatchmakingSession;
use Illuminate\Http\Request;

class MatchresearchController extends Controller
{

    public function index()
    {
        $sessions = MatchmakingSession::latest()->paginate(10);
        return view('admin_equity.matchresearch.index', compact('sessions'));
    }


    public function create()
    {
        return view('admin_equity.matchresearch.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);

        $validated['status'] = 'Buka';
        MatchmakingSession::create($validated);

        return redirect()->route('admin_equity.matchresearch.index')
                         ->with('success', 'Sesi Matchmaking berhasil dibuat!');
    }



    public function show($id, Request $request)
    {
        $session = MatchmakingSession::findOrFail($id);
        $fakultas = Fakultas::orderBy('name')->get();
        $query = $session->submissions()->with('user.profile.prodi.fakultas');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('judul_proposal', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                      $userQuery->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('prodi_id')) {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->whereHas('profile', function ($profileQuery) use ($request) {
                    $profileQuery->where('prodi_id', $request->prodi_id);
                });
            });
        }

        elseif ($request->filled('fakultas_id')) {
            $query->whereHas('user', function ($userQuery) use ($request) {
                $userQuery->whereHas('profile.prodi', function ($prodiQuery) use ($request) {
                    $prodiQuery->where('fakultas_id', $request->fakultas_id);
                });
            });
        }

        $submissions = $query->latest()->paginate(10)->withQueryString();

        return view('admin_equity.matchresearch.show', [
            'session' => $session,
            'submissions' => $submissions,
            'fakultas' => $fakultas,
            'request' => $request->all(),
        ]);
    }


    public function edit($id)
    {
        $session = MatchmakingSession::findOrFail($id);
        return view('admin_equity.matchresearch.edit', compact('session'));
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:Buka,Tutup',
        ]);

        $session = MatchmakingSession::findOrFail($id);
        $session->update($validated);

        return redirect()->route('admin_equity.matchresearch.index')
                         ->with('success', 'Sesi Matchmaking berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $session = MatchmakingSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin_equity.matchresearch.index')
                         ->with('success', 'Sesi Matchmaking berhasil dihapus!');
    }
}


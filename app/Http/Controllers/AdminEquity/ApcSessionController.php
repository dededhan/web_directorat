<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ApcSession;
use App\Models\ApcSubmission;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ApcSessionController extends Controller
{
    public function index()
    {
        ApcSession::syncSubmissionsForClosedSessions();
        $sessions = ApcSession::latest()->paginate(10);
        return view('admin_equity.apc.index', ['sessions' => $sessions]);
    }

    public function create()
    {
        return view('admin_equity.apc.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dana' => 'required|numeric|min:0',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        ]);
        $validated['status'] = 'Buka';

        ApcSession::create($validated);

        return redirect()->route('admin_equity.apc.index')->with('success', 'Sesi APC berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        ApcSession::syncSubmissionsForClosedSessions();

        $session = ApcSession::findOrFail($id);
        $fakultas = Fakultas::orderBy('name')->get();

        $query = ApcSubmission::with(['user.profile.prodi.fakultas'])
            ->where('apc_session_id', $id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul_artikel', 'like', "%{$search}%")
                  ->orWhere('nama_jurnal_q1', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
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

        return view('admin_equity.apc.show', [
            'session' => $session,
            'submissions' => $submissions,
            'fakultas' => $fakultas,
            'request' => $request->all(),
        ]);
    }

    public function edit($id)
    {
        $session = ApcSession::findOrFail($id);
        return view('admin_equity.apc.edit', compact('session'));
    }

    public function update(Request $request, $id)
    {
         $validated = $request->validate([
            'nama_sesi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'dana' => 'required|numeric|min:0',
            'periode_awal' => 'required|date',
            'periode_akhir' => 'required|date|after_or_equal:periode_awal',
            'status' => 'required|in:Buka,Tutup',
        ]);

        $session = ApcSession::findOrFail($id);
        
        $session->update($validated);

        ApcSession::syncSubmissionsForClosedSessions();

        return redirect()->route('admin_equity.apc.index')->with('success', 'Sesi APC berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $session = ApcSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin_equity.apc.index')->with('success', 'Sesi APC berhasil dihapus!');
    }
}

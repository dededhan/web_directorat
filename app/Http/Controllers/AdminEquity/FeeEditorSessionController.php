<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\Fakultas;
use App\Models\FeeEditorSession;
use App\Models\FeeEditorReport;
use Illuminate\Http\Request;

class FeeEditorSessionController extends Controller
{
    public function index()
    {
        $sessions = FeeEditorSession::latest()->paginate(10);
        return view('admin_equity.fee_editor.index', ['sessions' => $sessions]);
    }

    public function create()
    {
        return view('admin_equity.fee_editor.create');
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

        FeeEditorSession::create($validated);

        return redirect()->route('admin_equity.fee_editor.index')->with('success', 'Sesi Fee Editor berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        $session = FeeEditorSession::findOrFail($id);
        $fakultas = Fakultas::orderBy('name')->get();

        $query = FeeEditorReport::with('user.profile.prodi.fakultas')
            ->where('fee_editor_session_id', $id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama_jurnal', 'like', "%{$search}%")
                  ->orWhere('peran', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('prodi_id')) {
            $query->whereHas('user.profile', function ($profileQuery) use ($request) {
                $profileQuery->where('prodi_id', $request->prodi_id);
            });
        }
        elseif ($request->filled('fakultas_id')) {
            $query->whereHas('user.profile.prodi', function ($prodiQuery) use ($request) {
                $prodiQuery->where('fakultas_id', $request->fakultas_id);
            });
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        return view('admin_equity.fee_editor.show', [
            'session' => $session,
            'reports' => $reports,
            'fakultas' => $fakultas,
            'request' => $request->all(),
        ]);
    }

    public function edit($id)
    {
        $session = FeeEditorSession::findOrFail($id);
        return view('admin_equity.fee_editor.edit', compact('session'));
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

        $session = FeeEditorSession::findOrFail($id);
        
        $session->update($validated);

        return redirect()->route('admin_equity.fee_editor.index')->with('success', 'Sesi Fee Editor berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $session = FeeEditorSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin_equity.fee_editor.index')->with('success', 'Sesi Fee Editor berhasil dihapus!');
    }
}

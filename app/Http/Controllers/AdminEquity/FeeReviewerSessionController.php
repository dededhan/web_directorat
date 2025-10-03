<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\FeeReviewerSession;
use App\Models\FeeReviewerReport;
use Illuminate\Http\Request;

class FeeReviewerSessionController extends Controller
{
    public function index()
    {
        $sessions = FeeReviewerSession::latest()->paginate(10);
        return view('admin_equity.fee_reviewer.index', ['sessions' => $sessions]);
    }

    public function create()
    {
        return view('admin_equity.fee_reviewer.create');
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

        FeeReviewerSession::create($validated);

        return redirect()->route('admin_equity.fee_reviewer.index')->with('success', 'Sesi Fee Reviewer berhasil dibuat!');
    }

    public function show(Request $request, $id)
    {
        $session = FeeReviewerSession::findOrFail($id);

        $query = FeeReviewerReport::with('user')
            ->where('fee_reviewer_session_id', $id);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('judul_artikel', 'like', "%{$search}%")
                  ->orWhere('nama_jurnal', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $reports = $query->latest()->paginate(10)->withQueryString();

        return view('admin_equity.fee_reviewer.show', compact('session', 'reports'));
    }

    public function edit($id)
    {
        $session = FeeReviewerSession::findOrFail($id);
        return view('admin_equity.fee_reviewer.edit', compact('session'));
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

        $session = FeeReviewerSession::findOrFail($id);
        
        $session->update($validated);

        return redirect()->route('admin_equity.fee_reviewer.index')->with('success', 'Sesi Fee Reviewer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $session = FeeReviewerSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin_equity.fee_reviewer.index')->with('success', 'Sesi Fee Reviewer berhasil dihapus!');
    }
}

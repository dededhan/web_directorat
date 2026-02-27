<?php

namespace App\Http\Controllers\InovChallenge\Admin;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class InovChallengeSessionController extends Controller
{
    /**
     * Display a listing of the sessions.
     */
    public function index()
    {
        $sessions = InovChallengeSession::with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('inov_challenge.admin.sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new session.
     */
    public function create()
    {
        return view('inov_challenge.admin.sessions.create');
    }

    /**
     * Store a newly created session in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before_or_equal:end_date',
            'max_participants' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $session = InovChallengeSession::create([
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'registration_deadline' => $validated['registration_deadline'],
                'status' => 'draft',
                'max_participants' => $validated['max_participants'] ?? null,
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('admin.inov_challenge.sessions.index')
                ->with('success', 'Session Innovation Challenge berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat session: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified session.
     */
    public function show(InovChallengeSession $session)
    {
        $session->load(['creator', 'submissions', 'formBuilders']);

        $statistics = [
            'total_submissions' => $session->submissions()->count(),
            'draft_submissions' => $session->submissions()->where('final_status', 'draft')->count(),
            'submitted_submissions' => $session->submissions()->whereIn('final_status', ['submitted', 'under_review', 'reviewed'])->count(),
            'approved_submissions' => $session->submissions()->where('final_status', 'approved')->count(),
            'rejected_submissions' => $session->submissions()->where('final_status', 'rejected')->count(),
        ];

        return view('inov_challenge.admin.sessions.show', compact('session', 'statistics'));
    }

    /**
     * Show the form for editing the specified session.
     */
    public function edit(InovChallengeSession $session)
    {
        return view('inov_challenge.admin.sessions.edit', compact('session'));
    }

    /**
     * Update the specified session in storage.
     */
    public function update(Request $request, InovChallengeSession $session)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'registration_deadline' => 'required|date|before_or_equal:end_date',
            'status' => ['required', Rule::in(['draft', 'active', 'closed'])],
            'max_participants' => 'nullable|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $session->update($validated);

            DB::commit();

            return redirect()
                ->route('admin.inov_challenge.sessions.index')
                ->with('success', 'Session Innovation Challenge berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui session: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified session from storage.
     */
    public function destroy(InovChallengeSession $session)
    {
        // Check if session has submissions
        if ($session->submissions()->count() > 0) {
            return back()->with('error', 'Session tidak dapat dihapus karena sudah memiliki submission.');
        }

        try {
            DB::beginTransaction();

            // Delete related form builders
            $session->formBuilders()->delete();

            // Delete the session
            $session->delete();

            DB::commit();

            return redirect()
                ->route('admin.inov_challenge.sessions.index')
                ->with('success', 'Session Innovation Challenge berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus session: ' . $e->getMessage());
        }
    }

    /**
     * Activate the specified session.
     */
    public function activate(InovChallengeSession $session)
    {
        if ($session->status === 'active') {
            return back()->with('info', 'Session sudah dalam status aktif.');
        }

        if ($session->status === 'closed') {
            return back()->with('error', 'Session yang sudah ditutup tidak dapat diaktifkan kembali.');
        }

        // Validate session has required form builders for all phases
        $requiredPhases = ['phase_1', 'phase_2', 'phase_3'];
        $existingPhases = $session->formBuilders()->pluck('phase')->toArray();

        $missingPhases = array_diff($requiredPhases, $existingPhases);
        if (!empty($missingPhases)) {
            return back()->with('error', 'Session tidak dapat diaktifkan. Form builder untuk ' . implode(', ', $missingPhases) . ' belum dibuat.');
        }

        // Check if there's already an active session
        $activeSession = InovChallengeSession::where('status', 'active')
            ->where('id', '!=', $session->id)
            ->first();

        if ($activeSession) {
            // Option: Strict mode - only allow one active session at a time
            // To auto-close previous session instead, set config('inov_challenge.auto_close_active_session', false) to true
            $autoClose = config('inov_challenge.auto_close_active_session', false);

            if (!$autoClose) {
                return back()->with('error', 'Tidak dapat mengaktifkan session. Session "' . $activeSession->title . '" sedang aktif. Tutup session tersebut terlebih dahulu.');
            }

            // Auto-close the currently active session
            $activeSession->update(['status' => 'closed']);

            // Update draft submissions from closed session to cancelled
            $activeSession->submissions()->where('final_status', 'draft')->update([
                'final_status' => 'cancelled'
            ]);
        }

        try {
            DB::beginTransaction();

            $session->update(['status' => 'active']);

            // Send notifications to eligible participants (optional)
            // This could be expanded to notify users about the new active session

            DB::commit();

            $message = 'Session Innovation Challenge berhasil diaktifkan.';
            if (isset($autoClose) && $autoClose) {
                $message .= ' Session sebelumnya telah ditutup secara otomatis.';
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengaktifkan session: ' . $e->getMessage());
        }
    }

    /**
     * Close the specified session.
     */
    public function close(InovChallengeSession $session)
    {
        if ($session->status === 'closed') {
            return back()->with('info', 'Session sudah dalam status ditutup.');
        }

        if ($session->status === 'draft') {
            return back()->with('error', 'Session yang masih draft tidak dapat ditutup.');
        }

        try {
            DB::beginTransaction();

            $session->update(['status' => 'closed']);

            // Update all draft submissions to expired or cancelled
            $session->submissions()->where('final_status', 'draft')->update([
                'final_status' => 'cancelled'
            ]);

            DB::commit();

            return back()->with('success', 'Session Innovation Challenge berhasil ditutup.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menutup session: ' . $e->getMessage());
        }
    }
}

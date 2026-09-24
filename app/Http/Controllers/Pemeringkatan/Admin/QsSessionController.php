<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\QsSession;
use App\Models\QsSessionRespondent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QsSessionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $accessibleIds = $user->getAccessibleUserIds();

        $withCountConfig = [
            'sessionRespondents' => function ($q) use ($accessibleIds) {
                if ($accessibleIds !== null) {
                    $q->whereIn('added_by', $accessibleIds);
                }
            },
            'sessionRespondents as agreed_count' => function ($q) use ($accessibleIds) {
                $q->where('consent_status', 'agreed');
                if ($accessibleIds !== null) {
                    $q->whereIn('added_by', $accessibleIds);
                }
            },
            'sessionRespondents as pending_count' => function ($q) use ($accessibleIds) {
                $q->where('consent_status', 'pending');
                if ($accessibleIds !== null) {
                    $q->whereIn('added_by', $accessibleIds);
                }
            },
            'sessionRespondents as emailed_count' => function ($q) use ($accessibleIds) {
                $q->whereNotNull('email_sent_at');
                if ($accessibleIds !== null) {
                    $q->whereIn('added_by', $accessibleIds);
                }
            },
        ];

        $query = QsSession::query()->with('creator')->withCount($withCountConfig);

        // Non-directorate (Prodi & Fakultas) can only view active and closed sessions
        if (!$user->isDirectorateAdmin()) {
            $query->whereIn('status', ['active', 'closed']);
        } elseif ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $sessions = $query->latest()->paginate(15)->appends($request->query());

        return view('admin_pemeringkatan.qs-sessions.index', compact('sessions'));
    }

    public function create()
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak. Pembuatan sesi hanya dapat dilakukan oleh Admin Direktorat.');
        }

        return view('admin_pemeringkatan.qs-sessions.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak. Pembuatan sesi hanya dapat dilakukan oleh Admin Direktorat.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mode' => 'required|in:consent_only,form_based',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $validated['created_by'] = Auth::id();

        if ($validated['mode'] === 'form_based') {
            $sessionDummy = new QsSession();
            $validated['academic_form_schema'] = $sessionDummy->getDefaultFormSchema('academic');
            $validated['employee_form_schema'] = $sessionDummy->getDefaultFormSchema('employee');
        }

        $session = QsSession::create($validated);

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', 'Session berhasil dibuat!');
    }

    public function show(Request $request, QsSession $qs_session)
    {
        $user = Auth::user();
        $accessibleIds = $user->getAccessibleUserIds();

        // Non-directorate cannot access draft sessions
        if (!$user->isDirectorateAdmin() && $qs_session->status === 'draft') {
            abort(403, 'Sesi ini masih berstatus draft dan belum dibuka.');
        }

        $query = $qs_session->sessionRespondents()
            ->with(['bankRespondent.sourceUser', 'addedByUser', 'session.creator'])
            ->latest();

        // Multi-tier scoping: Prodi sees own, Fakultas sees own + prodis under it, Directorate sees all
        if ($accessibleIds !== null) {
            $query->whereIn('added_by', $accessibleIds);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('bankRespondent', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('consent_status')) {
            $query->where('consent_status', $request->consent_status);
        }

        if ($request->filled('email_status')) {
            if ($request->email_status === 'sent') {
                $query->whereNotNull('email_sent_at');
            } else {
                $query->whereNull('email_sent_at');
            }
        }

        $perPage = (int) $request->get('per_page', 50);
        if (!in_array($perPage, [25, 50, 100, 200])) {
            $perPage = 50;
        }

        $respondents = $query->paginate($perPage)->appends($request->query());

        // Calculate statistics scoped to user level
        $statsBase = $qs_session->sessionRespondents();
        if ($accessibleIds !== null) {
            $statsBase->whereIn('added_by', $accessibleIds);
        }

        $stats = [
            'totalResp' => (clone $statsBase)->count(),
            'agreedResp' => (clone $statsBase)->where('consent_status', 'agreed')->count(),
            'pendingResp' => (clone $statsBase)->where('consent_status', 'pending')->count(),
            'emailedResp' => (clone $statsBase)->whereNotNull('email_sent_at')->count(),
            'academicResp' => (clone $statsBase)->where('category', 'academic')->count(),
            'employeeResp' => (clone $statsBase)->where('category', 'employee')->count(),
        ];
        $stats['rate'] = $stats['totalResp'] > 0 ? round(($stats['agreedResp'] / $stats['totalResp']) * 100, 1) : 0;

        // Attempt logs for this session (Directorate only, or empty for non-directorate)
        $attemptLogs = $user->isDirectorateAdmin() 
            ? $qs_session->consentAttemptLogs()->latest('attempted_at')->limit(50)->get()
            : collect();

        return view('admin_pemeringkatan.qs-sessions.show', compact('qs_session', 'respondents', 'attemptLogs', 'stats'));
    }

    public function edit(QsSession $qs_session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak. Pengeditan sesi hanya dapat dilakukan oleh Admin Direktorat.');
        }

        return view('admin_pemeringkatan.qs-sessions.edit', compact('qs_session'));
    }

    public function update(Request $request, QsSession $qs_session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak. Pengeditan sesi hanya dapat dilakukan oleh Admin Direktorat.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mode' => 'required|in:consent_only,form_based',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,closed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        if ($validated['mode'] === 'form_based') {
            if (empty($qs_session->academic_form_schema)) {
                $validated['academic_form_schema'] = $qs_session->getDefaultFormSchema('academic');
            }
            if (empty($qs_session->employee_form_schema)) {
                $validated['employee_form_schema'] = $qs_session->getDefaultFormSchema('employee');
            }
        }

        // If closing, expire all pending respondents
        if ($validated['status'] === 'closed' && $qs_session->status !== 'closed') {
            $qs_session->sessionRespondents()
                ->where('consent_status', 'pending')
                ->update(['consent_status' => 'expired']);
        }

        $qs_session->update($validated);

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $qs_session)
            ->with('success', 'Session berhasil diperbarui!');
    }

    public function destroy(QsSession $qs_session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak. Penghapusan sesi hanya dapat dilakukan oleh Admin Direktorat.');
        }

        if ($qs_session->status === 'active' && $qs_session->agreed_count > 0) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus session aktif yang sudah memiliki consent.');
        }

        $qs_session->delete();

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.index')
            ->with('success', 'Session berhasil dihapus!');
    }
}

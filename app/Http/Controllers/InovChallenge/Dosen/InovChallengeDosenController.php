<?php

namespace App\Http\Controllers\InovChallenge\Dosen;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeSubmission;
use App\Models\InovChallengeFormBuilder;
use App\Models\InovChallengeUpload;
use App\Services\InovChallengeFormValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InovChallengeDosenController extends Controller
{
    protected $formValidationService;

    public function __construct(InovChallengeFormValidationService $formValidationService)
    {
        $this->formValidationService = $formValidationService;
    }

    /**
     * Display dosen dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get active sessions
        $activeSessions = InovChallengeSession::where('status', 'active')
            ->where('registration_deadline', '>=', now())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        // Get user's submissions
        $mySubmissions = InovChallengeSubmission::with(['session', 'teamMembers'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Statistics
        $stats = [
            'total_submissions' => InovChallengeSubmission::where('user_id', $user->id)->count(),
            'active_submissions' => InovChallengeSubmission::where('user_id', $user->id)
                ->whereIn('phase_1_status', ['draft', 'submitted', 'under_review'])
                ->count(),
            'approved_phase_1' => InovChallengeSubmission::where('user_id', $user->id)
                ->where('phase_1_status', 'approved')
                ->count(),
            'approved_phase_2' => InovChallengeSubmission::where('user_id', $user->id)
                ->where('phase_2_status', 'approved')
                ->count(),
            'approved_phase_3' => InovChallengeSubmission::where('user_id', $user->id)
                ->where('phase_3_status', 'approved')
                ->count(),
        ];
        
        return view('inov_challenge.dosen.dashboard', compact('activeSessions', 'mySubmissions', 'stats'));
    }

    /**
     * Display list of active sessions.
     */
    public function sessions()
    {
        $sessions = InovChallengeSession::where('status', 'active')
            ->where('registration_deadline', '>=', now())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $user = auth()->user();
        
        // Get session IDs where user has already joined
        $joinedSessionIds = InovChallengeSubmission::where('user_id', $user->id)
            ->pluck('session_id')
            ->toArray();
        
        return view('inov_challenge.dosen.sessions.index', compact('sessions', 'joinedSessionIds'));
    }

    /**
     * Display session detail.
     */
    public function sessionDetail(InovChallengeSession $session)
    {
        // Check if session is active
        if ($session->status !== 'active') {
            return redirect()->route('dosen.inov_challenge.sessions.index')
                ->with('error', 'Sesi ini tidak aktif.');
        }
        
        $user = auth()->user();
        
        // Check if user has already joined
        $hasJoined = InovChallengeSubmission::where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->exists();
        
        // Get form builders for this session
        $formBuilders = InovChallengeFormBuilder::where('session_id', $session->id)
            ->orderBy('phase')
            ->get()
            ->keyBy('phase');
        
        // Check if registration is still open
        $registrationOpen = $session->registration_deadline >= now();
        
        return view('inov_challenge.dosen.sessions.show', compact('session', 'hasJoined', 'formBuilders', 'registrationOpen'));
    }

    /**
     * Join a session (create initial submission).
     */
    public function joinSession(Request $request, InovChallengeSession $session)
    {
        $user = auth()->user();
        
        // Check if session is active
        if ($session->status !== 'active') {
            return back()->with('error', 'Sesi ini tidak aktif.');
        }
        
        // Check if registration is still open
        if ($session->registration_deadline < now()) {
            return back()->with('error', 'Pendaftaran untuk sesi ini sudah ditutup.');
        }
        
        // Check if user has already joined
        $existingSubmission = InovChallengeSubmission::where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->first();
        
        if ($existingSubmission) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $existingSubmission)
                ->with('info', 'Anda sudah terdaftar di sesi ini.');
        }
        
        // Check max participants (if set)
        if ($session->max_participants > 0) {
            $currentParticipants = InovChallengeSubmission::where('session_id', $session->id)->count();
            if ($currentParticipants >= $session->max_participants) {
                return back()->with('error', 'Kuota peserta untuk sesi ini sudah penuh.');
            }
        }
        
        try {
            DB::beginTransaction();
            
            // Create submission
            $submission = InovChallengeSubmission::create([
                'session_id' => $session->id,
                'user_id' => $user->id,
                'phase_1_status' => 'draft',
                'phase_2_status' => 'locked',
                'phase_3_status' => 'locked',
            ]);
            
            DB::commit();
            
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('success', 'Berhasil bergabung dengan sesi Innovation Challenge. Silakan lengkapi data Phase 1.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display user's submissions.
     */
    public function mySubmissions()
    {
        $user = auth()->user();
        
        $submissions = InovChallengeSubmission::with(['session', 'teamMembers', 'reviews'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('inov_challenge.dosen.submissions.index', compact('submissions'));
    }

    /**
     * Display submission dashboard.
     */
    public function showSubmission(InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to submission.');
        }
        
        $submission->load(['session', 'teamMembers', 'uploads', 'reviews.reviewer']);
        
        // Get form builders
        $formBuilders = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->orderBy('phase')
            ->get()
            ->keyBy('phase');
        
        // Calculate phase progress
        $phaseProgress = [
            'phase_1' => $this->calculatePhaseProgress($submission, 'phase_1'),
            'phase_2' => $this->calculatePhaseProgress($submission, 'phase_2'),
            'phase_3' => $this->calculatePhaseProgress($submission, 'phase_3'),
        ];
        
        return view('inov_challenge.dosen.submissions.show', compact('submission', 'formBuilders', 'phaseProgress'));
    }

    /**
     * Edit Phase 1 form.
     */
    public function editPhase1(InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if phase 1 is accessible
        if (!in_array($submission->phase_1_status, ['draft', 'rejected'])) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Phase 1 tidak dapat diedit karena status: ' . $submission->phase_1_status);
        }
        
        // Get form builder for phase 1
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', 'phase_1')
            ->first();
        
        if (!$formBuilder) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Form untuk Phase 1 belum tersedia.');
        }
        
        return view('inov_challenge.dosen.submissions.phase1', compact('submission', 'formBuilder'));
    }

    /**
     * Store Phase 1 submission.
     */
    public function storePhase1(Request $request, InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if phase 1 is accessible
        if (!in_array($submission->phase_1_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Phase 1 tidak dapat disubmit karena status: ' . $submission->phase_1_status);
        }
        
        // Get form builder
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', 'phase_1')
            ->first();
        
        if (!$formBuilder) {
            return back()->with('error', 'Form untuk Phase 1 belum tersedia.');
        }
        
        // Generate validation rules
        $validationRules = $this->formValidationService->generateValidationRules($formBuilder->form_config);
        
        // Add action validation
        $validationRules['action'] = 'required|in:save_draft,submit';
        
        // Validate request
        $validated = $request->validate($validationRules);
        
        try {
            DB::beginTransaction();
            
            $action = $request->input('action');
            
            // Prepare data (remove action field)
            $formData = $validated;
            unset($formData['action']);
            
            // Handle file uploads
            $formData = $this->handleFileUploads($request, $formData, $submission, 'phase_1');
            
            // Update submission
            $updateData = [
                'phase_1_data' => $formData,
                'phase_1_submitted_at' => $action === 'submit' ? now() : $submission->phase_1_submitted_at,
            ];
            
            if ($action === 'submit') {
                $updateData['phase_1_status'] = 'submitted';
            }
            
            $submission->update($updateData);
            
            // Create notification for admin (if submitted)
            if ($action === 'submit') {
                // TODO: Create notification in Sprint 7
            }
            
            DB::commit();
            
            $message = $action === 'submit' 
                ? 'Phase 1 berhasil disubmit. Menunggu review dari admin.' 
                : 'Phase 1 berhasil disimpan sebagai draft.';
            
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Edit Phase 2 form.
     */
    public function editPhase2(InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if phase 2 is accessible
        $requireSequential = config('inov_challenge.require_sequential_phases', true);
        
        if ($requireSequential && $submission->phase_1_status !== 'approved') {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Phase 2 hanya dapat diakses setelah Phase 1 disetujui.');
        }
        
        if (!in_array($submission->phase_2_status, ['draft', 'rejected'])) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Phase 2 tidak dapat diedit karena status: ' . $submission->phase_2_status);
        }
        
        // Get form builder for phase 2
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', 'phase_2')
            ->first();
        
        if (!$formBuilder) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Form untuk Phase 2 belum tersedia.');
        }
        
        return view('inov_challenge.dosen.submissions.phase2', compact('submission', 'formBuilder'));
    }

    /**
     * Store Phase 2 submission.
     */
    public function storePhase2(Request $request, InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if phase 2 is accessible
        $requireSequential = config('inov_challenge.require_sequential_phases', true);
        
        if ($requireSequential && $submission->phase_1_status !== 'approved') {
            return back()->with('error', 'Phase 2 hanya dapat disubmit setelah Phase 1 disetujui.');
        }
        
        if (!in_array($submission->phase_2_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Phase 2 tidak dapat disubmit karena status: ' . $submission->phase_2_status);
        }
        
        // Get form builder
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', 'phase_2')
            ->first();
        
        if (!$formBuilder) {
            return back()->with('error', 'Form untuk Phase 2 belum tersedia.');
        }
        
        // Generate validation rules
        $validationRules = $this->formValidationService->generateValidationRules($formBuilder->form_config);
        $validationRules['action'] = 'required|in:save_draft,submit';
        
        // Validate request
        $validated = $request->validate($validationRules);
        
        try {
            DB::beginTransaction();
            
            $action = $request->input('action');
            
            // Prepare data
            $formData = $validated;
            unset($formData['action']);
            
            // Handle file uploads
            $formData = $this->handleFileUploads($request, $formData, $submission, 'phase_2');
            
            // Update submission
            $updateData = [
                'phase_2_data' => $formData,
                'phase_2_submitted_at' => $action === 'submit' ? now() : $submission->phase_2_submitted_at,
            ];
            
            if ($action === 'submit') {
                $updateData['phase_2_status'] = 'submitted';
            }
            
            $submission->update($updateData);
            
            DB::commit();
            
            $message = $action === 'submit' 
                ? 'Phase 2 berhasil disubmit. Menunggu review dari admin.' 
                : 'Phase 2 berhasil disimpan sebagai draft.';
            
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Edit Phase 3 form.
     */
    public function editPhase3(InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if phase 3 is accessible
        $requireSequential = config('inov_challenge.require_sequential_phases', true);
        
        if ($requireSequential && $submission->phase_2_status !== 'approved') {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Phase 3 hanya dapat diakses setelah Phase 2 disetujui.');
        }
        
        if (!in_array($submission->phase_3_status, ['draft', 'rejected'])) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Phase 3 tidak dapat diedit karena status: ' . $submission->phase_3_status);
        }
        
        // Get form builder for phase 3
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', 'phase_3')
            ->first();
        
        if (!$formBuilder) {
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('error', 'Form untuk Phase 3 belum tersedia.');
        }
        
        return view('inov_challenge.dosen.submissions.phase3', compact('submission', 'formBuilder'));
    }

    /**
     * Store Phase 3 submission.
     */
    public function storePhase3(Request $request, InovChallengeSubmission $submission)
    {
        // Authorization check
        if ($submission->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Check if phase 3 is accessible
        $requireSequential = config('inov_challenge.require_sequential_phases', true);
        
        if ($requireSequential && $submission->phase_2_status !== 'approved') {
            return back()->with('error', 'Phase 3 hanya dapat disubmit setelah Phase 2 disetujui.');
        }
        
        if (!in_array($submission->phase_3_status, ['draft', 'rejected'])) {
            return back()->with('error', 'Phase 3 tidak dapat disubmit karena status: ' . $submission->phase_3_status);
        }
        
        // Get form builder
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', 'phase_3')
            ->first();
        
        if (!$formBuilder) {
            return back()->with('error', 'Form untuk Phase 3 belum tersedia.');
        }
        
        // Generate validation rules
        $validationRules = $this->formValidationService->generateValidationRules($formBuilder->form_config);
        $validationRules['action'] = 'required|in:save_draft,submit';
        
        // Validate request
        $validated = $request->validate($validationRules);
        
        try {
            DB::beginTransaction();
            
            $action = $request->input('action');
            
            // Prepare data
            $formData = $validated;
            unset($formData['action']);
            
            // Handle file uploads
            $formData = $this->handleFileUploads($request, $formData, $submission, 'phase_3');
            
            // Update submission
            $updateData = [
                'phase_3_data' => $formData,
                'phase_3_submitted_at' => $action === 'submit' ? now() : $submission->phase_3_submitted_at,
            ];
            
            if ($action === 'submit') {
                $updateData['phase_3_status'] = 'submitted';
            }
            
            $submission->update($updateData);
            
            DB::commit();
            
            $message = $action === 'submit' 
                ? 'Phase 3 berhasil disubmit. Menunggu review dari admin.' 
                : 'Phase 3 berhasil disimpan sebagai draft.';
            
            return redirect()->route('dosen.inov_challenge.submissions.show', $submission)
                ->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Handle file uploads for submission.
     */
    protected function handleFileUploads(Request $request, array $formData, InovChallengeSubmission $submission, string $phase)
    {
        foreach ($formData as $fieldName => $value) {
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                
                // Generate unique filename
                $filename = Str::slug($submission->id . '-' . $fieldName . '-' . time()) . '.' . $file->getClientOriginalExtension();
                
                // Store file
                $path = $file->storeAs('inov_challenge/submissions/' . $submission->id . '/' . $phase, $filename, 'public');
                
                // Create upload record
                $upload = InovChallengeUpload::create([
                    'submission_id' => $submission->id,
                    'phase' => $phase,
                    'field_name' => $fieldName,
                    'original_name' => $file->getClientOriginalName(),
                    'stored_name' => $filename,
                    'file_path' => $path,
                    'file_size' => $file->getSize(),
                    'mime_type' => $file->getMimeType(),
                ]);
                
                // Replace file object with file path in form data
                $formData[$fieldName] = $path;
            }
        }
        
        return $formData;
    }

    /**
     * Calculate phase progress percentage.
     */
    protected function calculatePhaseProgress(InovChallengeSubmission $submission, string $phase)
    {
        $phaseDataField = $phase . '_data';
        $phaseData = $submission->$phaseDataField;
        
        if (!$phaseData || !is_array($phaseData)) {
            return 0;
        }
        
        // Get form builder
        $formBuilder = InovChallengeFormBuilder::where('session_id', $submission->session_id)
            ->where('phase', $phase)
            ->first();
        
        if (!$formBuilder || !$formBuilder->form_config) {
            return 0;
        }
        
        $totalFields = count($formBuilder->form_config);
        $filledFields = 0;
        
        foreach ($formBuilder->form_config as $field) {
            $fieldName = $field['name'] ?? null;
            if ($fieldName && !empty($phaseData[$fieldName])) {
                $filledFields++;
            }
        }
        
        return $totalFields > 0 ? round(($filledFields / $totalFields) * 100) : 0;
    }
}

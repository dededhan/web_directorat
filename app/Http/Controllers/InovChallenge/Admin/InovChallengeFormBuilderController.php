<?php

namespace App\Http\Controllers\InovChallenge\Admin;

use App\Http\Controllers\Controller;
use App\Models\InovChallengeSession;
use App\Models\InovChallengeFormBuilder;
use App\Services\InovChallengeFormValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InovChallengeFormBuilderController extends Controller
{
    /**
     * Form validation service instance.
     */
    protected $validationService;

    /**
     * Create a new controller instance.
     */
    public function __construct(InovChallengeFormValidationService $validationService)
    {
        $this->validationService = $validationService;
    }
    /**
     * Display a listing of form builders for a session.
     */
    public function index(InovChallengeSession $session)
    {
        $formBuilders = $session->formBuilders()
            ->orderBy('phase')
            ->get();

        // Check which phases are missing
        $existingPhases = $formBuilders->pluck('phase')->toArray();
        $allPhases = ['phase_1', 'phase_2', 'phase_3'];
        $missingPhases = array_diff($allPhases, $existingPhases);

        return view('inov_challenge.admin.forms.index', compact('session', 'formBuilders', 'missingPhases'));
    }

    /**
     * Show the form for creating a new form builder.
     */
    public function create(InovChallengeSession $session, $phase)
    {
        // Validate phase
        if (!in_array($phase, ['phase_1', 'phase_2', 'phase_3'])) {
            return back()->with('error', 'Phase tidak valid.');
        }

        // Check if form for this phase already exists
        $existingForm = $session->formBuilders()->where('phase', $phase)->first();
        if ($existingForm) {
            return redirect()
                ->route('admin.inov_challenge.forms.edit', ['session' => $session->id, 'form' => $existingForm->id])
                ->with('info', 'Form untuk ' . $phase . ' sudah ada. Silakan edit form yang ada.');
        }

        // Default form field templates
        $defaultFields = $this->getDefaultFieldsByPhase($phase);

        return view('inov_challenge.admin.forms.create', compact('session', 'phase', 'defaultFields'));
    }

    /**
     * Store a newly created form builder in storage.
     */
    public function store(Request $request, InovChallengeSession $session)
    {
        $validated = $request->validate([
            'phase' => ['required', Rule::in(['phase_1', 'phase_2', 'phase_3'])],
            'form_config' => 'required|json',
        ]);

        // Check if form for this phase already exists
        $existingForm = $session->formBuilders()->where('phase', $validated['phase'])->first();
        if ($existingForm) {
            return back()
                ->withInput()
                ->with('error', 'Form untuk ' . $validated['phase'] . ' sudah ada.');
        }

        // Decode and validate form_config
        $formConfig = json_decode($validated['form_config'], true);
        if (!$this->validateFormConfig($formConfig)) {
            return back()
                ->withInput()
                ->with('error', 'Konfigurasi form tidak valid. Pastikan semua field memiliki name, label, dan type.');
        }

        try {
            DB::beginTransaction();

            $formBuilder = InovChallengeFormBuilder::create([
                'session_id' => $session->id,
                'phase' => $validated['phase'],
                'form_config' => $formConfig,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.inov_challenge.forms.index', ['session' => $session->id])
                ->with('success', 'Form builder untuk ' . $validated['phase'] . ' berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat form: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified form builder.
     */
    public function edit(InovChallengeSession $session, InovChallengeFormBuilder $form)
    {
        // Ensure form belongs to the session
        if ($form->session_id !== $session->id) {
            abort(404);
        }

        return view('inov_challenge.admin.forms.edit', compact('session', 'form'));
    }

    /**
     * Update the specified form builder in storage.
     */
    public function update(Request $request, InovChallengeSession $session, InovChallengeFormBuilder $form)
    {
        // Ensure form belongs to the session
        if ($form->session_id !== $session->id) {
            abort(404);
        }

        $validated = $request->validate([
            'form_config' => 'required|json',
        ]);

        // Decode and validate form_config
        $formConfig = json_decode($validated['form_config'], true);
        if (!$this->validateFormConfig($formConfig)) {
            return back()
                ->withInput()
                ->with('error', 'Konfigurasi form tidak valid. Pastikan semua field memiliki name, label, dan type.');
        }

        try {
            DB::beginTransaction();

            $form->update([
                'form_config' => $formConfig,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.inov_challenge.forms.index', ['session' => $session->id])
                ->with('success', 'Form builder untuk ' . $form->phase . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui form: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified form builder from storage.
     */
    public function destroy(InovChallengeSession $session, InovChallengeFormBuilder $form)
    {
        // Ensure form belongs to the session
        if ($form->session_id !== $session->id) {
            abort(404);
        }

        // Check if session is active
        if ($session->status === 'active') {
            return back()->with('error', 'Form tidak dapat dihapus karena session sedang aktif.');
        }

        // Check if there are submissions for this phase
        $hasSubmissions = $session->submissions()
            ->where(function ($query) use ($form) {
                $phaseStatusField = $form->phase . '_status';
                $query->whereNotNull($form->phase . '_data')
                    ->orWhereNotNull($phaseStatusField);
            })
            ->exists();

        if ($hasSubmissions) {
            return back()->with('error', 'Form tidak dapat dihapus karena sudah ada submission untuk phase ini.');
        }

        try {
            DB::beginTransaction();

            $phase = $form->phase;
            $form->delete();

            DB::commit();

            return redirect()
                ->route('admin.inov_challenge.forms.index', ['session' => $session->id])
                ->with('success', 'Form builder untuk ' . $phase . ' berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menghapus form: ' . $e->getMessage());
        }
    }

    /**
     * Show preview of the form.
     */
    public function preview(InovChallengeSession $session, InovChallengeFormBuilder $form)
    {
        // Ensure form belongs to the session
        if ($form->session_id !== $session->id) {
            abort(404);
        }

        return view('inov_challenge.admin.forms.preview', compact('session', 'form'));
    }

    /**
     * Get default fields by phase.
     */
    private function getDefaultFieldsByPhase($phase)
    {
        $defaults = [
            'phase_1' => [
                [
                    'name' => 'title',
                    'label' => 'Judul Proposal',
                    'type' => 'text',
                    'required' => true,
                    'placeholder' => 'Masukkan judul innovation challenge',
                ],
                [
                    'name' => 'abstract',
                    'label' => 'Abstract',
                    'type' => 'textarea',
                    'required' => true,
                    'placeholder' => 'Tuliskan abstract proposal Anda',
                    'rows' => 5,
                ],
                [
                    'name' => 'background',
                    'label' => 'Latar Belakang',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 10,
                ],
                [
                    'name' => 'objectives',
                    'label' => 'Tujuan',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 5,
                ],
                [
                    'name' => 'innovation_type',
                    'label' => 'Jenis Inovasi',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'product' => 'Produk',
                        'service' => 'Layanan',
                        'process' => 'Proses',
                        'technology' => 'Teknologi',
                    ],
                ],
                [
                    'name' => 'proposal_document',
                    'label' => 'Dokumen Proposal',
                    'type' => 'file',
                    'required' => true,
                    'accept' => '.pdf,.doc,.docx',
                    'max_size' => 10240, // KB
                ],
            ],
            'phase_2' => [
                [
                    'name' => 'implementation_plan',
                    'label' => 'Rencana Implementasi',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 10,
                ],
                [
                    'name' => 'timeline',
                    'label' => 'Timeline Kegiatan',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 8,
                ],
                [
                    'name' => 'budget',
                    'label' => 'RAB (Rencana Anggaran Biaya)',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 10,
                ],
                [
                    'name' => 'expected_output',
                    'label' => 'Output yang Diharapkan',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 5,
                ],
                [
                    'name' => 'implementation_document',
                    'label' => 'Dokumen Rencana Implementasi',
                    'type' => 'file',
                    'required' => true,
                    'accept' => '.pdf,.doc,.docx',
                    'max_size' => 10240,
                ],
            ],
            'phase_3' => [
                [
                    'name' => 'progress_report',
                    'label' => 'Laporan Progress',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 15,
                ],
                [
                    'name' => 'achievements',
                    'label' => 'Pencapaian',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 8,
                ],
                [
                    'name' => 'challenges',
                    'label' => 'Tantangan yang Dihadapi',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 5,
                ],
                [
                    'name' => 'sustainability',
                    'label' => 'Keberlanjutan Inovasi',
                    'type' => 'textarea',
                    'required' => true,
                    'rows' => 8,
                ],
                [
                    'name' => 'final_report',
                    'label' => 'Laporan Akhir',
                    'type' => 'file',
                    'required' => true,
                    'accept' => '.pdf',
                    'max_size' => 20480,
                ],
                [
                    'name' => 'supporting_documents',
                    'label' => 'Dokumen Pendukung (Foto, Video, dll)',
                    'type' => 'file',
                    'required' => false,
                    'accept' => '.pdf,.jpg,.jpeg,.png,.mp4',
                    'max_size' => 51200,
                    'multiple' => true,
                ],
            ],
        ];

        return $defaults[$phase] ?? [];
    }

    /**
     * Validate form configuration structure.
     */
    private function validateFormConfig($formConfig)
    {
        if (!is_array($formConfig)) {
            return false;
        }

        foreach ($formConfig as $field) {
            if (!isset($field['name']) || !isset($field['label']) || !isset($field['type'])) {
                return false;
            }

            // Validate type
            $validTypes = ['text', 'textarea', 'number', 'email', 'select', 'radio', 'checkbox', 'file', 'date'];
            if (!in_array($field['type'], $validTypes)) {
                return false;
            }

            // If type is select, radio, or checkbox, options must be provided
            if (in_array($field['type'], ['select', 'radio', 'checkbox']) && !isset($field['options'])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Validate submission data against form configuration.
     * This method is used by participant controllers to validate user submissions.
     * 
     * @param array $data
     * @param InovChallengeFormBuilder $form
     * @return array Validated data
     * @throws ValidationException
     */
    public function validateSubmissionData(array $data, InovChallengeFormBuilder $form): array
    {
        return $this->validationService->validateSubmissionData($data, $form->form_config);
    }

    /**
     * Get Laravel validation rules for a form.
     * Useful for custom validation scenarios.
     * 
     * @param InovChallengeFormBuilder $form
     * @return array
     */
    public function getValidationRules(InovChallengeFormBuilder $form): array
    {
        return $this->validationService->getRules($form->form_config);
    }

    /**
     * Test endpoint to preview validation rules for a form.
     * Only available in debug mode.
     * 
     * @param InovChallengeSession $session
     * @param InovChallengeFormBuilder $form
     * @return \Illuminate\Http\JsonResponse
     */
    public function showValidationRules(InovChallengeSession $session, InovChallengeFormBuilder $form)
    {
        // Only allow in debug mode
        if (!config('app.debug')) {
            abort(404);
        }

        // Ensure form belongs to the session
        if ($form->session_id !== $session->id) {
            abort(404);
        }

        $validation = $this->validationService->generateValidationRules($form->form_config);

        return response()->json([
            'phase' => $form->phase,
            'form_config' => $form->form_config,
            'validation_rules' => $validation['rules'],
            'validation_messages' => $validation['messages'],
            'validation_attributes' => $validation['attributes'],
            'required_fields' => $this->validationService->getRequiredFields($form->form_config),
        ], 200);
    }
}

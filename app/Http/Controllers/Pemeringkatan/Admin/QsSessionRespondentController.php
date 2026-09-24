<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Models\QsSession;
use App\Models\QsSessionRespondent;
use App\Models\RespondenBank;
use App\Mail\SessionConsentMail;
use App\Exports\SessionRespondentExport;
use App\Exports\SessionRespondentTemplateExport;
use App\Imports\SessionRespondentImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class QsSessionRespondentController extends Controller
{
    /**
     * Add a respondent directly within a session.
     * Automatically syncs to RespondenBank in the background for cross-session deduplication.
     */
    public function storeRespondent(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin() && $session->status !== 'active') {
            abort(403, 'Sesi ini tidak menerima penambahan responden.');
        }

        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:50',
            'category' => 'required|in:academic,employee',
            'institution' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'custom_fields' => 'nullable|array',
        ]);

        $email = strtolower(trim($validated['email']));
        $phone = $validated['phone'] ?? null;

        // Perform smart duplicate check
        $dupCheck = RespondenBank::checkDuplicateStatus($session->id, $email, $phone);

        if (!$dupCheck['allowed']) {
            return redirect()->back()
                ->withInput()
                ->with('error', $dupCheck['message']);
        }

        // Check if bank record already exists (e.g. from another pending session)
        $bank = $dupCheck['bank_respondent'] ?? RespondenBank::where('email', $email)->first();

        if (!$bank) {
            $bank = RespondenBank::create([
                'email' => $email,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'] ?? null,
                'title' => $validated['title'] ?? null,
                'phone' => $phone,
                'institution' => $validated['institution'] ?? null,
                'company_name' => $validated['company_name'] ?? null,
                'department' => $validated['department'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'country' => $validated['country'] ?? 'Indonesia',
                'category' => $validated['category'],
                'source' => 'manual',
                'source_user_id' => Auth::id(),
            ]);
        }

        // Extract session custom fields
        $schema = $session->getCustomFieldsSchema();
        $customValues = [];
        if (!empty($validated['custom_fields'])) {
            foreach ($schema as $field) {
                $key = $field['key'] ?? '';
                if ($key && isset($validated['custom_fields'][$key])) {
                    $customValues[$key] = $validated['custom_fields'][$key];
                }
            }
        }

        QsSessionRespondent::create([
            'qs_session_id' => $session->id,
            'responden_bank_id' => $bank->id,
            'category' => $validated['category'],
            'custom_fields' => !empty($customValues) ? $customValues : null,
            'token' => Str::random(64),
            'added_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', "Responden '{$validated['first_name']}' berhasil ditambahkan ke sesi ini.");
    }

    /**
     * Update an existing respondent within a session.
     */
    public function updateRespondent(Request $request, QsSession $session, QsSessionRespondent $respondent)
    {
        if ($respondent->qs_session_id !== $session->id) {
            return redirect()->back()->with('error', 'Responden tidak ditemukan di sesi ini.');
        }

        $accessibleIds = Auth::user()->getAccessibleUserIds();
        if ($accessibleIds !== null && !in_array($respondent->added_by, $accessibleIds)) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah data responden ini.');
        }

        $bank = $respondent->bankRespondent;

        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:responden_bank,email,' . $bank->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:50',
            'category' => 'required|in:academic,employee',
            'institution' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'custom_fields' => 'nullable|array',
        ]);

        $validated['email'] = strtolower(trim($validated['email']));

        $bank->update([
            'email' => $validated['email'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'title' => $validated['title'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'institution' => $validated['institution'] ?? null,
            'company_name' => $validated['company_name'] ?? null,
            'department' => $validated['department'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'country' => $validated['country'] ?? 'Indonesia',
        ]);

        // Filter and update custom fields
        $schema = $session->getCustomFieldsSchema();
        $customValues = is_array($respondent->custom_fields) ? $respondent->custom_fields : [];
        if (isset($validated['custom_fields'])) {
            foreach ($schema as $field) {
                $key = $field['key'] ?? '';
                if ($key && array_key_exists($key, $validated['custom_fields'])) {
                    $customValues[$key] = $validated['custom_fields'][$key];
                }
            }
        }

        $respondent->update([
            'category' => $validated['category'],
            'custom_fields' => !empty($customValues) ? $customValues : null,
        ]);

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', 'Data responden berhasil diperbarui.');
    }

    /**
     * Delete a single respondent from a session.
     */
    public function unassign(Request $request, QsSession $session, QsSessionRespondent $respondent)
    {
        if ($respondent->qs_session_id !== $session->id) {
            return redirect()->back()->with('error', 'Responden tidak ditemukan di sesi ini.');
        }

        $accessibleIds = Auth::user()->getAccessibleUserIds();
        if ($accessibleIds !== null && !in_array($respondent->added_by, $accessibleIds)) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus responden ini.');
        }

        $wasAgreed = $respondent->consent_status === 'agreed';
        $respondent->delete();

        $message = 'Responden berhasil dihapus dari sesi.';
        if ($wasAgreed) {
            $message .= ' Catatan: Persetujuan consent yang telah tercatat sebelumnya telah dicabut dari sesi ini, riwayat log audit tetap tersimpan.';
        }

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', $message);
    }

    /**
     * Bulk delete respondents from a session.
     */
    public function bulkDelete(Request $request, QsSession $session)
    {
        $validated = $request->validate([
            'respondent_ids' => 'required|array|min:1',
            'respondent_ids.*' => 'exists:qs_session_respondents,id',
        ]);

        $query = QsSessionRespondent::where('qs_session_id', $session->id)
            ->whereIn('id', $validated['respondent_ids']);

        $accessibleIds = Auth::user()->getAccessibleUserIds();
        if ($accessibleIds !== null) {
            $query->whereIn('added_by', $accessibleIds);
        }

        $deleted = $query->delete();

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', "Berhasil menghapus {$deleted} responden dari sesi.");
    }

    /**
     * Update the session's custom fields schema.
     */
    public function updateCustomFieldsSchema(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Hanya Admin Direktorat yang dapat mengubah format custom fields.');
        }
        $validated = $request->validate([
            'fields' => 'nullable|array',
            'fields.*.label' => 'required|string|max:100',
            'fields.*.key' => 'nullable|string|max:100',
            'fields.*.type' => 'required|in:text,number,date,select',
            'fields.*.options' => 'nullable|string',
            'fields.*.required' => 'nullable|boolean',
        ]);

        $cleanSchema = [];
        if (!empty($validated['fields'])) {
            foreach ($validated['fields'] as $item) {
                $label = trim($item['label']);
                $key = !empty($item['key']) ? Str::slug($item['key'], '_') : Str::slug($label, '_');

                $options = [];
                if ($item['type'] === 'select' && !empty($item['options'])) {
                    $options = array_values(array_filter(array_map('trim', explode(',', $item['options']))));
                }

                $cleanSchema[] = [
                    'key' => $key,
                    'label' => $label,
                    'type' => $item['type'],
                    'options' => $options,
                    'required' => !empty($item['required']),
                ];
            }
        }

        $session->update([
            'custom_fields_schema' => !empty($cleanSchema) ? $cleanSchema : null,
        ]);

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', 'Pengaturan custom fields sesi berhasil disimpan!');
    }

    /**
     * Export all respondents of this session to Excel.
     */
    public function export(Request $request, QsSession $session)
    {
        $accessibleIds = Auth::user()->getAccessibleUserIds();
        $status = $request->get('consent_status');
        $slug = Str::slug($session->name, '_');
        $suffix = $status === 'agreed' ? '_menjawab' : '';
        $fileName = "responden_{$slug}{$suffix}_" . now()->format('Ymd_His') . ".xlsx";
        return (new SessionRespondentExport($session, $status, $accessibleIds))->download($fileName);
    }

    /**
     * Download an Excel import template customized for this session.
     */
    public function downloadTemplate(QsSession $session)
    {
        $slug = Str::slug($session->name, '_');
        $fileName = "template_import_responden_{$slug}.xlsx";
        return (new SessionRespondentTemplateExport($session))->download($fileName);
    }

    /**
     * Dedicated page: Table of answered / consented respondents within this session.
     */
    public function answeredTable(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin() && $session->status === 'draft') {
            abort(404);
        }

        $accessibleIds = Auth::user()->getAccessibleUserIds();

        $query = $session->sessionRespondents()
            ->where('consent_status', 'agreed')
            ->with(['bankRespondent.sourceUser', 'addedByUser', 'session.creator']);

        if ($accessibleIds !== null) {
            $query->whereIn('added_by', $accessibleIds);
        }

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->whereHas('bankRespondent', function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category') && in_array($request->category, ['academic', 'employee'])) {
            $query->where('category', $request->category);
        }

        $perPage = (int) $request->get('per_page', 25);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 25;
        }

        $respondents = $query->latest('consented_at')->paginate($perPage)->appends($request->query());

        $countQuery = $session->sessionRespondents()->where('consent_status', 'agreed');
        if ($accessibleIds !== null) {
            $countQuery->whereIn('added_by', $accessibleIds);
        }
        $totalAnswered = (clone $countQuery)->count();
        $academicAnswered = (clone $countQuery)->where('category', 'academic')->count();
        $employeeAnswered = (clone $countQuery)->where('category', 'employee')->count();

        $academicSchema = $session->getFormSchema('academic');
        $employeeSchema = $session->getFormSchema('employee');

        return view('admin_pemeringkatan.qs-sessions.answered', [
            'session' => $session,
            'respondents' => $respondents,
            'totalAnswered' => $totalAnswered,
            'academicAnswered' => $academicAnswered,
            'employeeAnswered' => $employeeAnswered,
            'academicSchema' => $academicSchema,
            'employeeSchema' => $employeeSchema,
        ]);
    }

    /**
     * Assign bank respondents to a session.
     */
    public function assign(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'respondent_ids' => 'required|array|min:1',
            'respondent_ids.*' => 'exists:responden_bank,id',
            'category' => 'required|in:academic,employee',
        ]);

        $assigned = 0;
        $skipped = 0;

        foreach ($validated['respondent_ids'] as $bankId) {
            $exists = QsSessionRespondent::where('qs_session_id', $session->id)
                ->where('responden_bank_id', $bankId)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            QsSessionRespondent::create([
                'qs_session_id' => $session->id,
                'responden_bank_id' => $bankId,
                'category' => $validated['category'],
                'token' => Str::random(64),
                'added_by' => Auth::id(),
            ]);
            $assigned++;
        }

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', "Berhasil menambahkan {$assigned} responden. {$skipped} dilewati (sudah ada).");
    }

    /**
     * Import respondents from Excel into bank AND assign to session.
     */
    public function import(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin() && $session->status !== 'active') {
            abort(403, 'Sesi ini tidak menerima penambahan responden.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
            'category' => 'required|in:academic,employee',
        ]);

        try {
            $import = new SessionRespondentImport($session->id, $request->category);
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummaryMessage();

            return redirect()
                ->route('admin_pemeringkatan.qs-sessions.show', $session)
                ->with('success', "Import selesai! {$summary}");
        } catch (\Exception $e) {
            Log::error('Session import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Send consent emails (bulk or selective).
     */
    public function sendEmail(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Hanya Admin Direktorat yang dapat mengirim email blast ke responden.');
        }

        $validated = $request->validate([
            'respondent_ids' => 'nullable|array',
            'respondent_ids.*' => 'exists:qs_session_respondents,id',
            'send_all' => 'nullable|boolean',
        ]);

        $query = $session->sessionRespondents()->with('bankRespondent');

        if (!empty($validated['send_all'])) {
            $query->whereNull('email_sent_at');
        } elseif (!empty($validated['respondent_ids'])) {
            $query->whereIn('id', $validated['respondent_ids']);
        } else {
            return redirect()->back()->with('error', 'Pilih responden atau klik "Kirim Semua".');
        }

        $respondents = $query->get();
        $sent = 0;
        $failed = 0;

        foreach ($respondents as $sessionRespondent) {
            $bank = $sessionRespondent->bankRespondent;

            if (empty($bank->email)) {
                $failed++;
                continue;
            }

            if (empty($sessionRespondent->token)) {
                $sessionRespondent->update(['token' => Str::random(64)]);
                $sessionRespondent->refresh();
            }

            try {
                Mail::to($bank->email)->send(
                    new SessionConsentMail($bank, $sessionRespondent, $session)
                );

                $sessionRespondent->update([
                    'email_sent_at' => now(),
                    'email_count' => $sessionRespondent->email_count + 1,
                ]);

                $sent++;
            } catch (\Exception $e) {
                Log::error("Failed to send consent email to {$bank->email}: " . $e->getMessage());
                $failed++;
            }
        }

        $message = "Email terkirim: {$sent}.";
        if ($failed > 0) {
            $message .= " Gagal: {$failed}.";
        }

        return redirect()
            ->route('admin_pemeringkatan.qs-sessions.show', $session)
            ->with('success', $message);
    }

    /**
     * Re-send email to a specific respondent.
     */
    public function resend(QsSession $session, QsSessionRespondent $respondent)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Hanya Admin Direktorat yang dapat mengirim email ke responden.');
        }

        if ($respondent->qs_session_id !== $session->id) {
            return redirect()->back()->with('error', 'Responden tidak ditemukan di session ini.');
        }

        $bank = $respondent->bankRespondent;

        if (empty($bank->email)) {
            return redirect()->back()->with('error', 'Responden tidak memiliki email.');
        }

        if (empty($respondent->token)) {
            $respondent->update(['token' => Str::random(64)]);
            $respondent->refresh();
        }

        try {
            Mail::to($bank->email)->send(
                new SessionConsentMail($bank, $respondent, $session)
            );

            $respondent->update([
                'email_sent_at' => now(),
                'email_count' => $respondent->email_count + 1,
            ]);

            return redirect()->back()->with('success', "Email berhasil dikirim ulang ke {$bank->email}.");
        } catch (\Exception $e) {
            Log::error("Resend failed for {$bank->email}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }

    /**
     * AJAX: Get available bank respondents for assignment modal.
     */
    public function availableRespondents(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Akses ditolak.');
        }

        $query = RespondenBank::query();

        $assignedIds = $session->sessionRespondents()->pluck('responden_bank_id');
        $query->whereNotIn('id', $assignedIds);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $respondents = $query->orderBy('first_name')->paginate(25);

        return response()->json($respondents);
    }

    /**
     * AJAX endpoint to check availability/duplicate status of an email and phone.
     */
    public function checkRespondentAvailability(Request $request, QsSession $session)
    {
        $email = $request->query('email', '');
        $phone = $request->query('phone', null);

        if (empty($email)) {
            return response()->json([
                'allowed' => true,
                'status' => 'empty',
                'message' => 'Masukkan email responden.',
            ]);
        }

        $result = RespondenBank::checkDuplicateStatus($session->id, $email, $phone);

        return response()->json($result);
    }

    /**
     * Update questionnaire form schema for a session.
     */
    public function updateFormSchema(Request $request, QsSession $session)
    {
        if (!Auth::user()->isDirectorateAdmin()) {
            abort(403, 'Hanya Admin Direktorat yang dapat mengubah format formulir kuesioner.');
        }

        $academicSchema = $request->academic_form_schema;
        if (is_string($academicSchema)) {
            $academicSchema = json_decode($academicSchema, true);
        }

        $employeeSchema = $request->employee_form_schema;
        if (is_string($employeeSchema)) {
            $employeeSchema = json_decode($employeeSchema, true);
        }

        $session->update([
            'academic_form_schema' => $academicSchema ?? $session->academic_form_schema,
            'employee_form_schema' => $employeeSchema ?? $session->employee_form_schema,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Desain formulir kuesioner berhasil disimpan.',
            ]);
        }

        return redirect()->back()->with('success', 'Desain formulir kuesioner berhasil disimpan.');
    }

    /**
     * Dedicated detail page for an answered respondent within a session.
     */
    public function showRespondent(QsSession $session, QsSessionRespondent $respondent)
    {
        if ($respondent->qs_session_id !== $session->id) {
            abort(404, 'Responden tidak ditemukan di sesi ini.');
        }

        if (!Auth::user()->isDirectorateAdmin() && $session->status === 'draft') {
            abort(404);
        }

        $accessibleIds = Auth::user()->getAccessibleUserIds();
        if ($accessibleIds !== null && !in_array($respondent->added_by, $accessibleIds)) {
            abort(403, 'Anda tidak memiliki akses ke data responden ini.');
        }

        $respondent->load('bankRespondent');
        $bank = $respondent->bankRespondent;
        $category = $respondent->category ?? ($bank->category ?? 'academic');
        $schema = $session->getFormSchema($category);
        $customFieldsSchema = $session->getCustomFieldsSchema();
        $answers = $respondent->form_answers ?? [];

        return view('admin_pemeringkatan.qs-sessions.respondents.show', [
            'session' => $session,
            'respondent' => $respondent,
            'bank' => $bank,
            'category' => $category,
            'schema' => $schema,
            'customFieldsSchema' => $customFieldsSchema,
            'answers' => $answers,
        ]);
    }

    /**
     * AJAX: Show respondent's submitted answers.
     */
    public function showAnswers(QsSession $session, QsSessionRespondent $respondent)
    {
        $accessibleIds = Auth::user()->getAccessibleUserIds();
        if ($accessibleIds !== null && !in_array($respondent->added_by, $accessibleIds)) {
            abort(403, 'Anda tidak memiliki akses ke data responden ini.');
        }

        $respondent->load('bankRespondent');
        $category = $respondent->category ?? ($respondent->bankRespondent->category ?? 'academic');
        $schema = $session->getFormSchema($category);

        return response()->json([
            'respondent' => $respondent,
            'category' => $category,
            'schema' => $schema,
            'answers' => $respondent->form_answers ?? [],
            'submitted_at' => $respondent->form_submitted_at ? $respondent->form_submitted_at->format('d M Y H:i:s') : null,
        ]);
    }
}

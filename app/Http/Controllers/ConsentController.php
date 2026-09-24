<?php

namespace App\Http\Controllers;

use App\Models\QsSessionRespondent;
use App\Models\ConsentAttemptLog;
use Illuminate\Http\Request;

class ConsentController extends Controller
{
    /**
     * Show the consent landing page.
     */
    public function show(string $token)
    {
        $sessionRespondent = QsSessionRespondent::where('token', $token)
            ->with(['bankRespondent', 'session'])
            ->first();

        if (!$sessionRespondent) {
            return redirect()->route('consent.already_submitted');
        }

        // Check if already consented
        if ($sessionRespondent->consent_status === 'agreed') {
            $this->logAttempt($sessionRespondent, 'already_consented');
            return redirect()->route('consent.already_submitted');
        }

        // Check if email has globally consented in ANY session
        $email = $sessionRespondent->bankRespondent->email;
        $globallyConsented = QsSessionRespondent::whereHas('bankRespondent', fn($q) => $q->where('email', $email))
            ->where('consent_status', 'agreed')
            ->exists();

        if ($globallyConsented) {
            $this->logAttempt($sessionRespondent, 'already_consented');
            return redirect()->route('consent.already_submitted');
        }

        // Check if session is expired
        $session = $sessionRespondent->session;
        if ($session->status === 'closed' || ($session->end_date && $session->end_date->isPast())) {
            return view('consent.expired');
        }

        $bankRespondent = $sessionRespondent->bankRespondent;
        $fullname = trim(($bankRespondent->first_name ?? '') . ' ' . ($bankRespondent->last_name ?? ''));

        // If session is form-based, show the customized form page
        if ($session->isFormBased()) {
            $category = $sessionRespondent->category ?? ($bankRespondent->category ?? 'academic');
            $schema = $session->getFormSchema($category);

            return view('consent.form', [
                'token' => $token,
                'sessionRespondent' => $sessionRespondent,
                'bankRespondent' => $bankRespondent,
                'session' => $session,
                'schema' => $schema,
                'category' => $category,
                'fullname' => $fullname,
            ]);
        }

        return view('consent.show', [
            'token' => $token,
            'fullname' => $fullname,
            'email' => $bankRespondent->email,
            'session' => $session,
        ]);
    }

    /**
     * Process form submission and consent agreement.
     */
    public function submitForm(Request $request, string $token)
    {
        $sessionRespondent = QsSessionRespondent::where('token', $token)
            ->with(['bankRespondent', 'session'])
            ->first();

        if (!$sessionRespondent) {
            return redirect()->route('consent.already_submitted');
        }

        // Double-check: already consented?
        if ($sessionRespondent->consent_status === 'agreed') {
            $this->logAttempt($sessionRespondent, 'already_consented');
            return redirect()->route('consent.already_submitted');
        }

        // Check global duplicate
        $email = $sessionRespondent->bankRespondent->email;
        $globallyConsented = QsSessionRespondent::whereHas('bankRespondent', fn($q) => $q->where('email', $email))
            ->where('consent_status', 'agreed')
            ->exists();

        if ($globallyConsented) {
            $this->logAttempt($sessionRespondent, 'already_consented');
            return redirect()->route('consent.already_submitted');
        }

        // Check if session is expired
        $session = $sessionRespondent->session;
        if ($session->status === 'closed' || ($session->end_date && $session->end_date->isPast())) {
            return view('consent.expired');
        }

        $bank = $sessionRespondent->bankRespondent;
        $category = $sessionRespondent->category ?? ($bank->category ?? 'academic');
        $schema = $session->getFormSchema($category);

        // Build validation rules from schema
        $rules = [
            'consent_agreed' => 'required|accepted',
        ];

        // Standard fields validation
        $standardFields = $schema['standard_fields'] ?? [];
        foreach ($standardFields as $field => $config) {
            if (!empty($config['enabled'])) {
                $rule = [];
                if (!empty($config['required'])) {
                    $rule[] = 'required';
                } else {
                    $rule[] = 'nullable';
                }
                $rule[] = 'string';
                $rule[] = 'max:255';
                $rules[$field] = implode('|', $rule);
            }
        }

        // Custom questions validation
        $customQuestions = $schema['custom_questions'] ?? [];
        foreach ($customQuestions as $cq) {
            $qid = $cq['id'] ?? null;
            if (!$qid) continue;

            $rule = [];
            if (!empty($cq['required'])) {
                $rule[] = 'required';
            } else {
                $rule[] = 'nullable';
            }

            if (($cq['type'] ?? '') === 'number') {
                $rule[] = 'numeric';
            } else {
                $rule[] = 'string';
            }
            $rules['answers.' . $qid] = implode('|', $rule);
        }

        $validated = $request->validate($rules);

        // Update bank respondent contact profile with submitted standard fields (excluding email)
        $bankUpdates = [];
        $updatableFields = ['first_name', 'last_name', 'title', 'phone', 'institution', 'company_name', 'department', 'job_title', 'country'];
        foreach ($updatableFields as $f) {
            if ($request->has($f)) {
                $bankUpdates[$f] = $request->input($f);
            }
        }
        if (!empty($bankUpdates)) {
            $bank->update($bankUpdates);
        }

        // Collect custom answers and format nicely
        $submittedAnswers = $request->input('answers', []);

        // Record consent and form answers
        $sessionRespondent->update([
            'consent_status' => 'agreed',
            'consented_at' => now(),
            'form_submitted_at' => now(),
            'form_answers' => $submittedAnswers,
            'consent_ip' => $request->ip(),
            'token' => null, // Invalidate token to prevent reuse
        ]);

        $this->logAttempt($sessionRespondent, 'success');

        return redirect()->route('consent.thank_you');
    }

    /**
     * Process consent agreement.
     */
    public function agree(Request $request, string $token)
    {
        $sessionRespondent = QsSessionRespondent::where('token', $token)
            ->with(['bankRespondent', 'session'])
            ->first();

        if (!$sessionRespondent) {
            return redirect()->route('consent.already_submitted');
        }

        // Double-check: already consented?
        if ($sessionRespondent->consent_status === 'agreed') {
            $this->logAttempt($sessionRespondent, 'already_consented');
            return redirect()->route('consent.already_submitted');
        }

        // Check global duplicate
        $email = $sessionRespondent->bankRespondent->email;
        $globallyConsented = QsSessionRespondent::whereHas('bankRespondent', fn($q) => $q->where('email', $email))
            ->where('consent_status', 'agreed')
            ->exists();

        if ($globallyConsented) {
            $this->logAttempt($sessionRespondent, 'already_consented');
            return redirect()->route('consent.already_submitted');
        }

        // Record consent
        $sessionRespondent->update([
            'consent_status' => 'agreed',
            'consented_at' => now(),
            'consent_ip' => $request->ip(),
            'token' => null, // Invalidate token
        ]);

        // Log successful consent
        $this->logAttempt($sessionRespondent, 'success');

        return redirect()->route('consent.thank_you');
    }

    /**
     * Log a consent attempt.
     */
    private function logAttempt(QsSessionRespondent $respondent, string $result): void
    {
        ConsentAttemptLog::create([
            'email' => $respondent->bankRespondent->email ?? 'unknown',
            'qs_session_id' => $respondent->qs_session_id,
            'responden_bank_id' => $respondent->responden_bank_id,
            'token_used' => $respondent->token,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'attempted_at' => now(),
            'result' => $result,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendInternationalLectureGreeting;
use App\Models\DosenInternasional;
use App\Models\InternationalLectureGreeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InternationalLectureGreetingController extends Controller
{
    public function index()
    {
        $greetings = InternationalLectureGreeting::with('lecturer')
            ->latest()
            ->paginate(50);

        return view('admin_pemeringkatan.international-lecture.greeting.index', compact('greetings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'greeting_type' => 'required|in:unj_anniversary,lecturer_birthday,general',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:20000',
            'recipients' => 'required|string|max:100000',
        ]);

        $rawRecipients = preg_split('/[\\s,;]+/', trim($validated['recipients']), -1, PREG_SPLIT_NO_EMPTY);
        $recipients = [];
        foreach ($rawRecipients as $email) {
            $email = strtolower(trim($email));
            if ($email !== '' && !in_array($email, $recipients, true)) {
                $recipients[] = $email;
            }
        }

        if (count($recipients) > 250) {
            return back()->withInput()->withErrors([
                'recipients' => 'Maksimal 250 email dalam satu kali pengiriman greeting. Email yang terdeteksi: ' . count($recipients) . '.',
            ]);
        }

        $invalid = array_values(array_filter($recipients, fn ($email) => !filter_var($email, FILTER_VALIDATE_EMAIL)));
        if ($invalid) {
            return back()->withInput()->withErrors([
                'recipients' => 'Ada alamat email yang tidak valid: ' . implode(', ', array_slice($invalid, 0, 10)) . (count($invalid) > 10 ? ' ...' : ''),
            ]);
        }

        $batchId = (string) Str::uuid();

        DB::transaction(function () use ($recipients, $validated, $batchId) {
            foreach ($recipients as $email) {
                $lecturer = DosenInternasional::query()
                    ->whereRaw('LOWER(email) = ?', [$email])
                    ->first();

                $greeting = InternationalLectureGreeting::create([
                    'batch_id' => $batchId,
                    'greeting_type' => $validated['greeting_type'],
                    'subject' => $validated['subject'],
                    'message' => $validated['message'],
                    'lecturer_id' => $lecturer?->id,
                    'recipient_name' => $lecturer?->nama,
                    'recipient_email' => $email,
                    'email_status' => 'queued',
                    'email_error' => null,
                ]);

                SendInternationalLectureGreeting::dispatch($greeting->id)->afterCommit();
            }
        });

        return redirect()
            ->route('admin_pemeringkatan.international-lecture.greeting.index')
            ->with('success', count($recipients) . ' email greeting dimasukkan ke antrean pengiriman.');
    }
}

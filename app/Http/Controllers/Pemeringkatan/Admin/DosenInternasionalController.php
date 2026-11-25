<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Exports\InternationalLecturerDataExport;
use App\Exports\InternationalLecturerTemplateExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasRoleBasedViews;
use App\Http\Requests\StoreDosenInternasionalRequest;
use App\Imports\InternationalLecturerImport;
use App\Jobs\SendInternationalLecturerEmail;
use App\Models\AktivitasDosenAsing;
use App\Models\DosenInternasional;
use App\Models\EmailTemplate;
use App\Models\InternationalLecturerEmailLog;
use App\Models\InternationalLecturerEmailTemplate;
use App\Services\LecturerDataSanitizer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DosenInternasionalController extends Controller
{
    use HasRoleBasedViews;

    public function index(Request $request)
    {
        $query = $this->applyFilters($request, DosenInternasional::withCount('activities'));

        $lecturers = $query->latest()->paginate(20)->appends($request->query());
        $subjects = config('international_lecture.subjects') ?? [];
        $availableSessions = ['123', '124', '125', '126', '127'];
        $currentSession = '125';
        $emailTemplates = [
            'en' => EmailTemplate::getTemplate('academic', 'en'),
            'id' => EmailTemplate::getTemplate('academic', 'id'),
        ];

        $isMissing = static function ($query, string $column): void {
            $query->whereNull($column)
                ->orWhere($column, '')
                ->orWhere($column, 'Belum Diisi');
        };

        $hasMissingActivity = static function ($query): void {
            $query->whereDoesntHave('activities');
        };

        $invalidEmailIds = DosenInternasional::query()
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->get(['id', 'email'])
            ->reject(fn ($l) => \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email))
            ->pluck('id');

        // Data Quality hanya memeriksa field yang memang diminta untuk dipantau:
        // Nama, Jabatan, Gender, Institusi, Negara, Subject, Email, dan Kegiatan.
        $incompleteQuery = DosenInternasional::query()->where(function ($q) use ($isMissing, $hasMissingActivity, $invalidEmailIds) {
            $isMissing($q, 'nama');
            $q->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'jabatan'); })
              ->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'jenis_kelamin'); })
              ->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'universitas_asal'); })
              ->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'negara'); })
              ->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'subject_1'); })
              ->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'email'); })
              ->orWhere(function ($sub) use ($isMissing) { $isMissing($sub, 'tahun'); })
              ->orWhere(function ($sub) use ($hasMissingActivity) { $hasMissingActivity($sub); })
              ->orWhereIn('id', $invalidEmailIds);
        });

        $stats = [
            'total' => DosenInternasional::count(),
            'sent' => DosenInternasional::whereIn('email_status', ['sent', 'queued', 'sending'])->count(),
            'not_sent' => DosenInternasional::where(function ($q) {
                $q->whereNull('email_status')
                  ->orWhere('email_status', '')
                  ->orWhere('email_status', 'not_sent');
            })->count(),
            'incomplete' => (clone $incompleteQuery)->count(),
            'missing' => [
                'nama' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'nama'); })->count(),
                'jabatan' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'jabatan'); })->count(),
                'jenis_kelamin' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'jenis_kelamin'); })->count(),
                'universitas_asal' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'universitas_asal'); })->count(),
                'negara' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'negara'); })->count(),
                'subject_1' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'subject_1'); })->count(),
                'email' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'email'); })->count(),
                'email_belum_fix' => $invalidEmailIds->count(),
                'tahun' => DosenInternasional::where(function ($q) use ($isMissing) { $isMissing($q, 'tahun'); })->count(),
                'kegiatan' => DosenInternasional::whereDoesntHave('activities')->count(),
            ],
        ];

        return view($this->resolveViewByRole('international-lecture.index'), compact('lecturers', 'subjects', 'emailTemplates', 'availableSessions', 'currentSession', 'stats'));
    }

    /**
     * Filter yang sama dipakai di halaman utama dan halaman Kirim Email.
     */
    private function applyFilters(Request $request, Builder $query): Builder
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('negara', 'like', "%{$search}%")
                    ->orWhere('universitas_asal', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sesi')) {
            $query->where('sesi', $request->sesi);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subject')) {
            $query->where(function ($q) use ($request) {
                $q->where('subject_1', $request->subject)
                    ->orWhere('subject_2', $request->subject);
            });
        }

        $isFilterBelumFix = $request->email_status === 'email_belum_fix'
            || $request->kelengkapan_data === 'email_belum_fix'
            || $request->category === 'email_belum_fix'
            || $request->filled('email_belum_fix');

        if ($isFilterBelumFix) {
            $invalidIds = DosenInternasional::query()
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->get(['id', 'email'])
                ->reject(fn ($l) => \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email))
                ->pluck('id');

            $query->whereIn('id', $invalidIds);
        }

        if ($request->filled('kelengkapan_data') && $request->kelengkapan_data !== 'email_belum_fix') {
            $kd = $request->kelengkapan_data;
            $missing = static function ($query, string $column): void {
                $query->whereNull($column)
                    ->orWhere($column, '')
                    ->orWhere($column, 'Belum Diisi');
            };

            if ($kd === 'incomplete') {
                $invalidEmailIds = DosenInternasional::query()
                    ->whereNotNull('email')
                    ->where('email', '!=', '')
                    ->get(['id', 'email'])
                    ->reject(fn ($l) => \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email))
                    ->pluck('id');

                $query->where(function ($q) use ($missing, $invalidEmailIds) {
                    $missing($q, 'nama');
                    $q->orWhere(function ($sub) use ($missing) { $missing($sub, 'jabatan'); })
                      ->orWhere(function ($sub) use ($missing) { $missing($sub, 'jenis_kelamin'); })
                      ->orWhere(function ($sub) use ($missing) { $missing($sub, 'universitas_asal'); })
                      ->orWhere(function ($sub) use ($missing) { $missing($sub, 'negara'); })
                      ->orWhere(function ($sub) use ($missing) { $missing($sub, 'subject_1'); })
                      ->orWhere(function ($sub) use ($missing) { $missing($sub, 'email'); })
                      ->orWhere(function ($sub) use ($missing) { $missing($sub, 'tahun'); })
                      ->orWhereDoesntHave('activities')
                      ->orWhereIn('id', $invalidEmailIds);
                });
            } elseif ($kd === 'missing_nama') {
                $query->where(function ($q) use ($missing) { $missing($q, 'nama'); });
            } elseif ($kd === 'missing_jabatan') {
                $query->where(function ($q) use ($missing) { $missing($q, 'jabatan'); });
            } elseif ($kd === 'missing_gender') {
                $query->where(function ($q) use ($missing) { $missing($q, 'jenis_kelamin'); });
            } elseif ($kd === 'missing_universitas') {
                $query->where(function ($q) use ($missing) { $missing($q, 'universitas_asal'); });
            } elseif ($kd === 'missing_negara') {
                $query->where(function ($q) use ($missing) { $missing($q, 'negara'); });
            } elseif ($kd === 'missing_subject') {
                $query->where(function ($q) use ($missing) { $missing($q, 'subject_1'); });
            } elseif ($kd === 'missing_email') {
                $query->where(function ($q) use ($missing) { $missing($q, 'email'); });
            } elseif ($kd === 'missing_tahun') {
                $query->where(function ($q) use ($missing) { $missing($q, 'tahun'); });
            } elseif ($kd === 'missing_kegiatan') {
                $query->whereDoesntHave('activities');
            } elseif ($kd === 'complete') {
                $invalidEmailIds = DosenInternasional::query()
                    ->whereNotNull('email')
                    ->where('email', '!=', '')
                    ->get(['id', 'email'])
                    ->reject(fn ($l) => \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email))
                    ->pluck('id');

                $query->whereNotNull('nama')->where('nama', '!=', '')
                    ->whereNotNull('jabatan')->where('jabatan', '!=', '')
                    ->whereNotNull('jenis_kelamin')->where('jenis_kelamin', '!=', '')
                    ->whereNotNull('universitas_asal')->where('universitas_asal', '!=', '')
                    ->whereNotNull('negara')->where('negara', '!=', '')
                    ->whereNotNull('subject_1')->where('subject_1', '!=', '')
                    ->whereNotNull('email')->where('email', '!=', '')
                    ->whereNotIn('id', $invalidEmailIds)
                    ->whereNotNull('tahun')->where('tahun', '!=', '')
                    ->whereHas('activities');
            }
        }

        if ($request->filled('email_status') && $request->email_status !== 'email_belum_fix') {
            if ($request->email_status === 'sent') {
                $query->whereIn('email_status', ['sent', 'queued', 'sending']);
            } elseif ($request->email_status === 'not_sent') {
                $query->where(function ($q) {
                    $q->whereNull('email_status')
                      ->orWhere('email_status', '')
                      ->orWhere('email_status', 'not_sent');
                });
            } elseif ($request->email_status === 'failed') {
                $query->where('email_status', 'failed');
            } else {
                $query->where('email_status', $request->email_status);
            }
        }

        return $query;
    }

    /**
     * Halaman tersendiri untuk kirim email (template sistem / manual) ke banyak dosen asing.
     */
    public function emailIndex(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [20, 50, 100], true) ? (int) $request->per_page : 20;

        $lecturers = $this->applyFilters($request, DosenInternasional::withCount('activities'))
            ->latest()
            ->paginate($perPage)
            ->appends($request->query());

        // Semua dosen (sesuai filter) yang punya email, untuk fitur "pilih semua hasil filter".
        $filteredRecipients = $this->applyFilters($request, DosenInternasional::query())
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->latest()
            ->get(['id', 'nama', 'email', 'subject_1', 'jenis_kelamin', 'jabatan', 'universitas_asal', 'negara', 'tahun'])
            ->filter(function ($l) {
                return \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email);
            })
            ->map(function ($l) {
                $missing = [];
                if (empty($l->email)) $missing[] = 'Email';
                if (empty($l->subject_1)) $missing[] = 'Subject';
                if (empty($l->jenis_kelamin)) $missing[] = 'Jenis Kelamin';
                if (empty($l->jabatan)) $missing[] = 'Jabatan';
                if (empty($l->universitas_asal)) $missing[] = 'Institusi Asal';
                if (empty($l->negara)) $missing[] = 'Negara';
                if (empty($l->tahun)) $missing[] = 'Tahun';

                return [
                    'id' => $l->id,
                    'name' => $l->nama,
                    'email' => $l->email,
                    'missing' => $missing,
                    'editUrl' => route('admin_pemeringkatan.international-lecture.edit', $l->id),
                ];
            })
            ->values();

        $subjects = config('international_lecture.subjects') ?? [];
        $textTemplates = config('international_lecture.email_templates') ?? [];

        $dailyLimit = InternationalLecturerEmailLog::dailyLimit();
        $usedToday = InternationalLecturerEmailLog::countedToday();
        $remainingQuota = max(0, $dailyLimit - $usedToday);

        // Preview template sistem (QS Academic Respondent) dengan data contoh.
        $templateEn = EmailTemplate::getTemplate('academic', 'en');
        $templateId = EmailTemplate::getTemplate('academic', 'id');
        $hasSystemTemplate = (bool) ($templateEn || $templateId);
        $sampleLecturer = new DosenInternasional([
            'nama' => 'Prof. Dr. John Doe',
            'email' => 'john.doe@university.edu',
            'universitas_asal' => 'University of Example',
            'negara' => 'United Kingdom',
        ]);
        $systemPreviews = [];
        foreach (['bilingual', 'en', 'id'] as $mode) {
            $systemPreviews[$mode] = view('emails.international-lecturer-invitation', [
                'lecturer' => $sampleLecturer,
                'templateEn' => $templateEn,
                'templateId' => $templateId,
                'consentLink' => '#',
                'displayTitle' => 'Prof. Dr.',
                'languageMode' => $mode,
            ])->render();
        }
        $systemSubjects = [
            'bilingual' => $templateEn?->subject ?? 'Consent Letter for Academic Respondent Universitas Negeri Jakarta QS World University Ranking',
            'en' => $templateEn?->subject ?? 'Consent Letter for Academic Respondent Universitas Negeri Jakarta QS World University Ranking',
            'id' => $templateId?->subject ?? 'Consent Letter for Academic Respondent Universitas Negeri Jakarta QS World University Ranking',
        ];

        $recentBatches = InternationalLecturerEmailLog::query()
            ->selectRaw("batch_id, mode, MAX(subject) as subject, COUNT(*) as total,
                SUM(CASE WHEN status = 'sent' THEN 1 ELSE 0 END) as sent_count,
                SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed_count,
                SUM(CASE WHEN status IN ('queued','sending') THEN 1 ELSE 0 END) as pending_count,
                MIN(created_at) as first_at")
            ->whereNotNull('batch_id')
            ->groupBy('batch_id', 'mode')
            ->orderByDesc('first_at')
            ->limit(5)
            ->get()
            ->each(fn ($b) => $b->first_at = Carbon::parse($b->first_at));

        $user = Auth::user();
        $dbTemplates = InternationalLecturerEmailTemplate::accessibleFor($user?->id)
            ->orderByDesc('is_system')
            ->orderByDesc('created_at')
            ->get();

        return view($this->resolveViewByRole('international-lecture.email'), compact(
            'lecturers',
            'filteredRecipients',
            'subjects',
            'textTemplates',
            'dbTemplates',
            'dailyLimit',
            'usedToday',
            'remainingQuota',
            'hasSystemTemplate',
            'systemPreviews',
            'systemSubjects',
            'recentBatches',
            'perPage'
        ));
    }

    /**
     * Kirim email ke banyak dosen asing sekaligus (maks. sesuai sisa kuota harian).
     */
    public function sendBulkEmail(Request $request)
    {
        $dailyLimit = InternationalLecturerEmailLog::dailyLimit();

        $validated = $request->validate([
            'mode' => 'required|in:template,manual',
            'template_id' => 'nullable|string',
            'language_mode' => 'nullable|in:bilingual,en,id',
            'subject' => 'nullable|required_if:mode,manual|string|max:255',
            'body' => 'nullable|required_if:mode,manual|string|max:20000',
            'include_consent_button' => 'nullable|boolean',
            'button_text' => 'nullable|string|max:100',
            'email_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'lecturer_ids' => 'required|array|min:1|max:' . $dailyLimit,
            'lecturer_ids.*' => 'integer|distinct',
        ], [
            'lecturer_ids.required' => 'Pilih minimal satu dosen penerima.',
            'lecturer_ids.max' => "Maksimal {$dailyLimit} email per hari.",
            'subject.required_if' => 'Subjek email wajib diisi untuk mode tulis manual.',
            'body.required_if' => 'Isi email wajib diisi untuk mode tulis manual.',
        ]);

        $ids = array_unique(array_map('intval', $validated['lecturer_ids']));
        $allSelected = DosenInternasional::whereIn('id', $ids)->get();

        // Validasi ketat: Cegah pengiriman jika ada dosen dengan email sembarang / tidak fix / dummy
        $invalidLecturers = $allSelected->filter(function ($l) {
            return !\App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email);
        });

        if ($invalidLecturers->isNotEmpty()) {
            $sampleNames = $invalidLecturers->take(3)->map(function ($l) {
                $reason = null;
                \App\Services\LecturerDataSanitizer::isFixDeliverableEmail($l->email, $reason);
                $e = $l->email ?: 'Kosong';
                return "{$l->nama} ({$e} - {$reason})";
            })->implode(', ');

            $more = $invalidLecturers->count() > 3 ? " dan " . ($invalidLecturers->count() - 3) . " dosen lainnya" : "";

            return redirect()->back()->withInput()->with('error', 
                "Email tidak dapat dikirim langsung! Terdapat {$invalidLecturers->count()} dosen terpilih yang memiliki email sembarang atau belum fix: {$sampleNames}{$more}. Email harus fix sesuai email yang dituju sebelum dapat dikirim."
            );
        }

        $lecturers = $allSelected;
        $skipped = 0;

        $remaining = InternationalLecturerEmailLog::remainingToday();
        if ($lecturers->count() > $remaining) {
            return redirect()->back()->withInput()->with('error', sprintf(
                'Kuota email harian tidak mencukupi. Dipilih %d dosen, sisa kuota hari ini %d dari %d email.',
                $lecturers->count(),
                $remaining,
                $dailyLimit
            ));
        }

        $mode = $validated['mode'];
        $templateId = $validated['template_id'] ?? 'default_qs';
        $languageMode = $validated['language_mode'] ?? 'bilingual';

        // Foto hanya berlaku untuk pengiriman yang sedang dibuat pada form ini.
        $attachmentPath = null;
        if ($request->hasFile('email_photo')) {
            $attachmentPath = $request->file('email_photo')->store('international-lecture-email-attachments', 'public');
        }

        if ($mode === 'manual') {
            $customContent = [
                'subject' => $validated['subject'],
                'body' => $validated['body'],
                'include_consent_button' => (bool) ($validated['include_consent_button'] ?? false),
                'button_text' => $validated['button_text'] ?? null,
                'attachment_path' => $attachmentPath,
            ];
            $logSubject = Str::limit($validated['subject'], 250);
        } elseif ($templateId && $templateId !== 'default_qs') {
            $selectedTemplate = InternationalLecturerEmailTemplate::accessibleFor(Auth::id())
                ->findOrFail((int) $templateId);

            $customContent = [
                'subject' => $selectedTemplate->subject,
                'body' => $selectedTemplate->body,
                'include_consent_button' => (bool) $selectedTemplate->include_consent_button,
                'button_text' => $selectedTemplate->button_text,
                'attachment_path' => $attachmentPath,
            ];
            $logSubject = Str::limit('[Template: ' . $selectedTemplate->title . '] ' . $selectedTemplate->subject, 250);
        } else {
            // default_qs
            $customContent = ['attachment_path' => $attachmentPath];
            $logSubject = 'Template Sistem QS Academic Respondent (' . $languageMode . ')';
        }

        $batchId = (string) Str::uuid();
        $interval = max(0, (int) config('international_lecture.email_dispatch_interval', 2));

        try {
            foreach ($lecturers->values() as $i => $lecturer) {
                if (!$lecturer->consent_token) {
                    $lecturer->consent_token = (string) Str::uuid();
                }
                $lecturer->email_status = 'queued';
                $lecturer->email_sent_at = null;
                $lecturer->email_error = null;
                $lecturer->save();

                $log = InternationalLecturerEmailLog::create([
                    'dosen_internasional_id' => $lecturer->id,
                    'batch_id' => $batchId,
                    'recipient_email' => $lecturer->email,
                    'mode' => $mode,
                    'language_mode' => ($mode === 'template' && $templateId === 'default_qs') ? $languageMode : null,
                    'subject' => $logSubject,
                    'status' => 'queued',
                    'sent_by' => Auth::id(),
                ]);

                SendInternationalLecturerEmail::dispatch($lecturer->id, $languageMode, $log->id, $customContent)
                    ->delay(now()->addSeconds($i * $interval));
            }
        } catch (\Throwable $e) {
            Log::error('International lecturer bulk email dispatch failed', ['exception' => $e, 'batch_id' => $batchId]);
            return redirect()->back()->withInput()->with('error', 'Gagal memasukkan email ke antrean: ' . $e->getMessage());
        }

        $message = sprintf(
            '%d email dimasukkan ke antrean pengiriman.%s Sisa kuota hari ini: %d dari %d.',
            $lecturers->count(),
            $skipped > 0 ? " {$skipped} dosen dilewati karena tidak memiliki email." : '',
            InternationalLecturerEmailLog::remainingToday(),
            $dailyLimit
        );

        return redirect()->back()
            ->with('success', $message)
            ->with('email_batch_sent', true);
    }

    /**
     * Simpan template email baru (dari user via tulis manual, atau dari admin).
     * Disimpan per akun (user_id = Auth::id()) kecuali jika admin menandai sebagai system template.
     */
    public function storeTemplate(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:20000',
            'include_consent_button' => 'nullable|boolean',
            'button_text' => 'nullable|string|max:100',
            'is_system' => 'nullable|boolean',
        ]);

        $isAdmin = $user && in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan']);
        $isSystem = $isAdmin && !empty($validated['is_system']);

        $template = InternationalLecturerEmailTemplate::create([
            'user_id' => $isSystem ? null : ($user?->id ?? null),
            'title' => $validated['title'],
            'subject' => $validated['subject'],
            'body' => $validated['body'],
            'include_consent_button' => (bool) ($validated['include_consent_button'] ?? false),
            'button_text' => $validated['button_text'] ?? null,
            'is_system' => $isSystem,
            'created_by_name' => $user?->name ?? 'Admin',
            'created_by_email' => $user?->email ?? null,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Template berhasil disimpan ' . ($isSystem ? 'sebagai Template Sistem (Tampil untuk Semua).' : 'khusus untuk Akun Anda.'),
                'template' => $template,
            ]);
        }

        return redirect()->back()->with('success', 'Template email berhasil disimpan.');
    }

    /**
     * Hapus template email (hanya pemilik akun atau admin).
     */
    public function destroyTemplate(Request $request, $id)
    {
        $user = Auth::user();
        $template = InternationalLecturerEmailTemplate::findOrFail($id);

        $isAdmin = $user && in_array($user->role, ['admin_direktorat', 'admin_pemeringkatan']);

        if (!$isAdmin && $template->user_id !== $user?->id) {
            abort(403, 'Anda tidak berhak menghapus template ini.');
        }

        $template->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Template berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Template email berhasil dihapus.');
    }

    public function create()
    {
        $subjects = config('international_lecture.subjects') ?? [];
        $activityTypes = config('international_lecture.activity_types') ?? [];
        $academicDesignations = config('international_lecture.academic_designations') ?? [];
        $employerDesignations = config('international_lecture.employer_designations') ?? [];
        $countries = config('international_lecture.countries') ?? [];
        $countryOptions = LecturerDataSanitizer::countrySearchIndex();

        return view($this->resolveViewByRole('international-lecture.create'), compact(
            'subjects',
            'activityTypes',
            'academicDesignations',
            'employerDesignations',
            'countries',
            'countryOptions'
        ));
    }

    public function store(StoreDosenInternasionalRequest $request)
    {
        try {
            $data = $request->validated();
            $data['email_status'] = 'not_sent';

            // Ambil nilai kegiatan dari kolom "Kegiatan Dosen di Kampus" (status)
            // sebelum dosen disimpan, agar bisa dibuat aktivitas otomatis.
            $kegiatanDosen = !empty($data['status']) ? $data['status'] : null;

            $lecturer = DosenInternasional::create($data);

            // Jika kolom "Kegiatan Dosen di Kampus", tanggal, atau link bukti terisi, otomatis buat 1 record aktivitas
            if ($kegiatanDosen || !empty($data['tanggal']) || !empty($data['link_bukti_kegiatan'])) {
                $tanggal = !empty($data['tanggal']) ? $data['tanggal'] : null;
                $linkBukti = !empty($data['link_bukti_kegiatan']) ? $data['link_bukti_kegiatan'] : null;
                $namaKegiatan = $kegiatanDosen ?: 'Kegiatan di Kampus';

                $lecturer->activities()->create([
                    'tanggal'             => $tanggal,
                    'jenis_kegiatan'      => $namaKegiatan,
                    'judul'               => $namaKegiatan,
                    'keterangan'          => $namaKegiatan,
                    'isi'                 => $namaKegiatan,
                    'link_bukti_kegiatan' => $linkBukti,
                ]);
            }

            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'), ['table' => 1])
                ->with('success', 'International lecturer data has been successfully added!');
        } catch (\Exception $e) {
            Log::error('International lecturer store error', ['exception' => $e]);
            return redirect()->back()->withInput()->with('error', 'Failed to save data: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $lecturer = DosenInternasional::with('activities')->findOrFail($id);
        return response()->json($lecturer);
    }

    public function edit(string $id)
    {
        $lecturer = DosenInternasional::with('activities')->findOrFail($id);
        $subjects = config('international_lecture.subjects') ?? [];
        $activityTypes = config('international_lecture.activity_types') ?? [];
        $academicDesignations = config('international_lecture.academic_designations') ?? [];
        $employerDesignations = config('international_lecture.employer_designations') ?? [];
        $countries = config('international_lecture.countries') ?? [];
        $countryOptions = LecturerDataSanitizer::countrySearchIndex();

        return view($this->resolveViewByRole('international-lecture.edit'), compact(
            'lecturer',
            'subjects',
            'activityTypes',
            'academicDesignations',
            'employerDesignations',
            'countries',
            'countryOptions'
        ));
    }

    public function getDosenDetail($id)
    {
        return response()->json(DosenInternasional::with('activities')->findOrFail($id));
    }

    public function update(Request $request, string $id)
    {
        $merge = [];
        if ($request->has('negara')) {
            $merge['negara'] = LecturerDataSanitizer::normalizeCountry($request->input('negara')) ?? $request->input('negara');
        }
        if ($request->has('subject_1')) {
            $merge['subject_1'] = LecturerDataSanitizer::normalizeSubject(
                $request->input('subject_1'),
                $request->input('fakultas'),
                $request->input('prodi')
            ) ?? $request->input('subject_1');
        }
        if ($merge) {
            $request->merge($merge);
        }

        $validatedData = $request->validate([
            // Identitas Dosen (Wajib)
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Male,Female,Other',
            'jabatan' => 'required|string|max:255',
            'universitas_asal' => 'required|string|max:255',
            'negara' => ['required', 'string', 'max:255', Rule::in(config('international_lecture.countries', []))],
            'email' => [
                'required',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $reason = null;
                    if (!\App\Services\LecturerDataSanitizer::isFixDeliverableEmail($value, $reason)) {
                        $fail("Email tidak valid: {$reason}.");
                    }
                },
            ],
            'subject_1' => ['required', 'string', 'max:255', Rule::in(config('international_lecture.subjects', []))],

            // Academic Details
            'fakultas' => 'required|string|max:255',
            'prodi' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'sesi' => 'required|string|max:50',
            'tahun' => 'required|string|max:10',
            'link_bukti_kegiatan' => 'nullable|string|max:1000',

            // Dihapus dari form
            'subject_2' => 'nullable|string|max:255',
            'bidang_keahlian' => 'nullable|string|max:255',
        ], [
            'nama.required' => 'Nama dosen asing wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jabatan.required' => 'Jabatan wajib dipilih.',
            'universitas_asal.required' => 'Institusi asal wajib diisi.',
            'negara.required' => 'Negara wajib diisi.',
            'negara.in' => 'Negara harus dipilih dari daftar negara yang tersedia.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject_1.required' => 'Subject wajib dipilih.',
            'subject_1.in' => 'Subject harus dipilih dari daftar resmi QS.',
            'fakultas.required' => 'Fakultas wajib dipilih.',
            'tahun.required' => 'Tahun Dosen Datang wajib diisi.',
            'sesi.required' => 'Sesi (Semester) wajib diisi.',
        ]);

        try {
            $lecturer = DosenInternasional::findOrFail($id);
            $lecturer->update($validatedData);

            // Sinkronkan ke aktivitas jika ada Kegiatan Dosen di Kampus (status)
            $kegiatanDosen = !empty($validatedData['status']) ? trim($validatedData['status']) : null;
            if ($kegiatanDosen) {
                $linkBukti = !empty($validatedData['link_bukti_kegiatan']) ? trim($validatedData['link_bukti_kegiatan']) : null;
                $tahun = $validatedData['tahun'] ?? $lecturer->tahun ?? now()->year;
                $tanggal = is_numeric($tahun)
                    ? \Illuminate\Support\Carbon::create((int) $tahun, 1, 1)->toDateString()
                    : now()->toDateString();

                // Cari aktivitas dengan jenis kegiatan yang sama
                $existingActivity = $lecturer->activities()
                    ->whereRaw("LOWER(TRIM(COALESCE(jenis_kegiatan, ''))) = ?", [mb_strtolower($kegiatanDosen)])
                    ->first();

                if (!$existingActivity) {
                    // Jika belum ada kegiatan sejenis (atau belum punya kegiatan sama sekali), buat record baru
                    $lecturer->activities()->create([
                        'tanggal'             => $tanggal,
                        'jenis_kegiatan'      => $kegiatanDosen,
                        'judul'               => $kegiatanDosen,
                        'keterangan'          => $kegiatanDosen,
                        'isi'                 => $kegiatanDosen,
                        'link_bukti_kegiatan' => $linkBukti,
                    ]);
                } else if ($linkBukti && $existingActivity->link_bukti_kegiatan !== $linkBukti) {
                    // Update tautan bukti jika berubah
                    $existingActivity->update([
                        'link_bukti_kegiatan' => $linkBukti,
                    ]);
                }
            }

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data dosen berhasil diperbarui!']);
            }

            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'), ['table' => 1])
                ->with('success', 'International lecturer data has been successfully updated!');
        } catch (\Exception $e) {
            Log::error('International lecturer update error', ['exception' => $e]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to update data: ' . $e->getMessage()], 422);
            }
            return redirect()->back()->withInput()->with('error', 'Failed to update data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            DosenInternasional::findOrFail($id)->delete();
            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'), ['table' => 1])
                ->with('success', 'International lecturer data has been successfully deleted!');
        } catch (\Exception $e) {
            Log::error('International lecturer delete error', ['exception' => $e]);
            return redirect()->back()->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new InternationalLecturerTemplateExport(), 'template-international-lecture.xlsx');
    }

    public function exportExcel(Request $request)
    {
        $filename = 'data-dosen-internasional-' . now()->format('Ymd-His') . '.xlsx';
        return Excel::download(new InternationalLecturerDataExport($request->query()), $filename);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        try {
            ini_set('memory_limit', '512M');
            set_time_limit(300);

            $import = new InternationalLecturerImport();
            $import->import($request->file('file')->getRealPath());
            $summary = $import->summary;

            $message = sprintf(
                "Import selesai. %d data baru, %d data diperbarui, %d data dilewati.",
                $summary['created'],
                $summary['updated'],
                $summary['skipped']
            );

            if ($summary['errors']) {
                $message .= "\n" . implode("\n", array_slice($summary['errors'], 0, 10));
            }

            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'), ['table' => 1])
                ->with('success', $message);
        } catch (\Throwable $e) {
            Log::error('International lecturer Excel import failed', ['exception' => $e]);
            return redirect()->back()->with('error', 'Import Excel gagal: ' . $e->getMessage());
        }
    }

    public function sendEmail(Request $request, string $id)
    {
        $validated = $request->validate([
            'language_mode' => 'nullable|in:bilingual,en,id',
        ]);

        $lecturer = DosenInternasional::findOrFail($id);
        $reason = null;
        if (!\App\Services\LecturerDataSanitizer::isFixDeliverableEmail($lecturer->email, $reason)) {
            $eText = $lecturer->email ?: 'belum diisi';
            return redirect()->back()->with('error', "Email tidak dapat dikirim langsung! Email dosen {$lecturer->nama} ({$eText}) tidak valid atau masih diisi sembarang ({$reason}). Email harus fix sesuai email yang dituju sebelum dapat dikirim.");
        }

        if (InternationalLecturerEmailLog::remainingToday() < 1) {
            return redirect()->back()->with('error', sprintf(
                'Kuota email harian (%d email/hari) sudah habis. Silakan kirim kembali besok.',
                InternationalLecturerEmailLog::dailyLimit()
            ));
        }

        if (!$lecturer->consent_token) {
            $lecturer->update(['consent_token' => (string) Str::uuid()]);
            $lecturer->refresh();
        }

        $lecturer->update([
            'email_status' => 'queued',
            'email_sent_at' => null,
            'email_error' => null,
        ]);

        $languageMode = $validated['language_mode'] ?? 'bilingual';
        $log = InternationalLecturerEmailLog::create([
            'dosen_internasional_id' => $lecturer->id,
            'recipient_email' => $lecturer->email,
            'mode' => 'template',
            'language_mode' => $languageMode,
            'subject' => 'Template Sistem QS Academic Respondent (' . $languageMode . ')',
            'status' => 'queued',
            'sent_by' => Auth::id(),
        ]);

        SendInternationalLecturerEmail::dispatch(
            $lecturer->id,
            $languageMode,
            $log->id
        );

        return redirect()->back()->with('success', 'Email template QS Academic Respondent dimasukkan ke antrean untuk ' . $lecturer->nama . '.');
    }

    public function showConsent(string $token)
    {
        $lecturer = DosenInternasional::where('consent_token', $token)->firstOrFail();
        return view('international-lecture.consent', compact('lecturer'));
    }

    public function agreeConsent(string $token)
    {
        $lecturer = DosenInternasional::where('consent_token', $token)->firstOrFail();
        $lecturer->update([
            'consent_status' => 'agreed',
            'consented_at' => now(),
        ]);

        return view('international-lecture.consent-result', [
            'success' => true,
            'lecturer' => $lecturer,
        ]);
    }

    public function declineConsent(string $token)
    {
        $lecturer = DosenInternasional::where('consent_token', $token)->firstOrFail();
        $lecturer->update([
            'consent_status' => 'declined',
            'consented_at' => null,
        ]);

        return view('international-lecture.consent-result', [
            'success' => false,
            'lecturer' => $lecturer,
        ]);
    }

    public function addActivity(Request $request, string $id)
    {
        $validated = $request->validate([
            'jenis_kegiatan'      => 'required|string|max:255',
            'link_bukti_kegiatan' => 'nullable|string|max:1000',
            'tanggal'             => 'required|date',
            'judul'               => 'nullable|string|max:200',
            'keterangan'          => 'nullable|string|max:5000',
        ], [
            'jenis_kegiatan.required' => 'Kegiatan dosen di kampus wajib dipilih atau diisi.',
            'tanggal.required'        => 'Tanggal Kegiatan wajib diisi.',
            'tanggal.date'            => 'Format Tanggal Kegiatan tidak valid.',
        ]);

        $lecturer = DosenInternasional::findOrFail($id);

        $activityType = trim($validated['jenis_kegiatan']);
        $title = !empty(trim($validated['judul'] ?? '')) ? trim($validated['judul']) : $activityType;
        
        $tanggal = !empty($validated['tanggal']) ? $validated['tanggal'] : null;

        $linkBukti = !empty($validated['link_bukti_kegiatan']) ? trim($validated['link_bukti_kegiatan']) : null;

        $lecturer->activities()->create([
            'tanggal'             => $tanggal,
            'jenis_kegiatan'      => $activityType,
            'judul'               => $title,
            'keterangan'          => $validated['keterangan'] ?? $title,
            'isi'                 => $validated['keterangan'] ?? $title,
            'link_bukti_kegiatan' => $linkBukti,
        ]);

        // Sinkronkan ke master dosen jika status atau link bukti kegiatan utama masih kosong
        $syncMaster = [];
        if (empty($lecturer->status)) {
            $syncMaster['status'] = $activityType;
        }
        if (empty($lecturer->link_bukti_kegiatan) && $linkBukti) {
            $syncMaster['link_bukti_kegiatan'] = $linkBukti;
        }
        if (!empty($syncMaster)) {
            $lecturer->update($syncMaster);
        }

        return redirect()->back()->with('success', 'Kegiatan dosen berhasil ditambahkan.');
    }

    public function deleteActivity(string $id, string $activityId)
    {
        $activity = AktivitasDosenAsing::where('dosen_internasional_id', $id)->findOrFail($activityId);
        $activity->delete();
        return redirect()->back();
    }

    public function updateActivity(Request $request, string $id, string $activityId)
    {
        $validated = $request->validate([
            'jenis_kegiatan'      => 'required|string|max:255',
            'link_bukti_kegiatan' => 'nullable|string|max:1000',
            'tanggal'             => 'required|date',
        ], [
            'jenis_kegiatan.required' => 'Kegiatan dosen di kampus wajib dipilih atau diisi.',
            'tanggal.required'        => 'Tanggal Kegiatan wajib diisi.',
            'tanggal.date'            => 'Format Tanggal Kegiatan tidak valid.',
        ]);

        $activity = AktivitasDosenAsing::where('dosen_internasional_id', $id)->findOrFail($activityId);
        $activityType = trim($validated['jenis_kegiatan']);
        $linkBukti = !empty($validated['link_bukti_kegiatan']) ? trim($validated['link_bukti_kegiatan']) : null;
        $tanggal = !empty($validated['tanggal']) ? $validated['tanggal'] : null;

        $activity->update([
            'jenis_kegiatan'      => $activityType,
            'judul'               => $activityType,
            'link_bukti_kegiatan' => $linkBukti,
            'tanggal'             => $tanggal,
        ]);

        return redirect()->back();
    }

    private function replacePlaceholders(string $text, DosenInternasional $lecturer): string
    {
        return strtr($text, [
            '{{nama}}' => $lecturer->nama,
            '{{email}}' => $lecturer->email ?? '',
            '{{jabatan}}' => $lecturer->jabatan ?? '',
            '{{universitas_asal}}' => $lecturer->universitas_asal,
            '{{negara}}' => $lecturer->negara,
            '{{subject_1}}' => $lecturer->subject_1 ?? '',
            '{{subject_2}}' => $lecturer->subject_2 ?? '',
            '{{fakultas}}' => $lecturer->fakultas,
            '{{prodi}}' => $lecturer->prodi,
        ]);
    }
}

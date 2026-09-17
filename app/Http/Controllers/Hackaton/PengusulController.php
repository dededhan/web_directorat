<?php

namespace App\Http\Controllers\Hackaton;

use App\Http\Controllers\Controller;
use App\Models\HackatonSession;
use App\Models\HackatonSubmission;
use App\Models\HackatonSubmissionIdentitas;
use App\Models\HackatonSubmissionMember;
use App\Models\HackatonSubmissionTahap;
use App\Models\HackatonSubmissionFieldValue;
use App\Models\HackatonStatusLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengusulController extends Controller
{
    /**
     * Active sessions list for pengusul (dosen & tendik).
     */
    public function sessions()
    {
        $sessions = HackatonSession::where('status', 'active')
            ->with('tahap')
            ->withCount('submissions')
            ->latest()
            ->paginate(12);

        return view('subdirektorat-inovasi.hackaton.pengusul.sessions.index', compact('sessions'));
    }

    /**
     * Show session detail with 3 Tahap overview.
     */
    public function showSession(HackatonSession $session)
    {
        abort_if($session->status !== 'active', 404);

        $session->load('tahap.fields');

        $existingSubmission = HackatonSubmission::where('hackaton_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        return view('subdirektorat-inovasi.hackaton.pengusul.sessions.show', compact('session', 'existingSubmission'));
    }

    /**
     * List user's own submissions across all sessions.
     */
    public function mySubmissions()
    {
        $submissions = HackatonSubmission::where('user_id', Auth::id())
            ->with(['session', 'submissionTahap.tahap', 'reviewers', 'members'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.index', compact('submissions'));
    }

    /**
     * Store new submission + auto-create 3 submission_tahap rows.
     */
    public function store(Request $request, HackatonSession $session)
    {
        abort_if($session->status !== 'active', 404);

        $request->validate([
            'tema' => 'required|string|max:255',
        ], [
            'tema.required' => 'Silakan pilih tema inovasi terlebih dahulu sebelum mendaftarkan proposal.',
        ]);

        $existing = HackatonSubmission::where('hackaton_session_id', $session->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existing) {
            return redirect()
                ->route('hackaton.submissions.show', $existing)
                ->with('error', 'Anda sudah memiliki proposal untuk sesi ini.');
        }

        $submission = DB::transaction(function () use ($session, $request) {
            $submission = HackatonSubmission::create([
                'hackaton_session_id' => $session->id,
                'user_id'             => Auth::id(),
                'tema'                => $request->tema,
                'status'              => 'draft',
            ]);

            foreach ($session->tahap as $tahap) {
                HackatonSubmissionTahap::create([
                    'hackaton_submission_id' => $submission->id,
                    'hackaton_tahap_id'      => $tahap->id,
                    'status'                 => 'belum_diisi',
                    'admin_status'           => 'menunggu',
                ]);
            }

            $user = Auth::user();
            $user->load('profile.fakultas', 'profile.prodi');

            $institusi = null;
            if ($user->profile?->fakultas) {
                $institusi = $user->profile->fakultas->name;
                if ($user->profile->prodi) {
                    $institusi .= ' / ' . $user->profile->prodi->name;
                }
            } elseif ($user->profile?->institusi) {
                $institusi = $user->profile->institusi;
            }

            $tipe = str_replace('hackaton_', '', $user->role);
            if (!in_array($tipe, HackatonSubmissionMember::TIPE_OPTIONS)) {
                $tipe = 'dosen';
            }

            $submission->members()->create([
                'user_id'            => $user->id,
                'peran'              => 'Ketua',
                'peran_ic'           => 'Hustler',
                'tipe_anggota'       => $tipe,
                'nama_lengkap'       => $user->name,
                'nik_nim_nip'        => $user->profile?->identifier_number,
                'institusi_fakultas' => $institusi,
                'approval_status'    => 'not_required',
            ]);

            HackatonStatusLog::logSubmissionStatus(
                $submission->id,
                null,
                'draft',
                'Proposal Hackaton baru dibuat',
                $user->id,
                $user->role
            );

            return $submission;
        });

        return redirect()
            ->route('hackaton.submissions.show', $submission)
            ->with('success', 'Proposal Hackaton berhasil dibuat. Silakan lengkapi identitas tim dan tahapan.');
    }

    /**
     * Show submission detail with 3-Tahap progress tracker.
     */
    public function showSubmission(HackatonSubmission $submission)
    {
        $user = Auth::user();
        $isOwner = $submission->user_id === $user->id;
        $isMember = $submission->members()->where('user_id', $user->id)->exists();
        $isAdmin = in_array($user->role ?? '', ['admin_hackaton', 'superadmin']) || ($user->hasRole('admin_hackaton') ?? false);
        $isReviewer = $submission->reviewers()->where('users.id', $user->id)->exists();

        abort_unless($isOwner || $isMember || $isAdmin || $isReviewer, 403, 'Anda tidak memiliki akses ke proposal ini.');

        $submission->load([
            'session',
            'submissionTahap.tahap',
            'members.user.profile.fakultas',
            'members.user.profile.prodi',
            'identitas',
            'user.profile.fakultas',
            'user.profile.prodi',
            'reviewers',
            'reviews.reviewer',
            'reviews.tahap',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        $hasReviewer = $submission->reviewers->isNotEmpty();

        $ketuaMember = $submission->members->firstWhere('peran', 'Ketua');
        $anggotaMembers = $submission->members->where('peran', '!=', 'Ketua')->values();

        $defaultKetuaNama = $ketuaMember?->nama_lengkap ?? $submission->user?->name ?? '';
        $defaultKetuaNik = $ketuaMember?->nik_nim_nip ?? $submission->user?->profile?->identifier_number ?? '';

        $defaultKetuaInstansi = $ketuaMember?->institusi_fakultas;
        if (empty($defaultKetuaInstansi) && $submission->user?->profile) {
            $prodi = $submission->user->profile->prodi?->name;
            $fakultas = $submission->user->profile->fakultas?->name;
            $parts = array_filter([$prodi, $fakultas, 'Universitas Negeri Jakarta']);
            $defaultKetuaInstansi = implode(' / ', $parts);
        }
        if (empty($defaultKetuaInstansi)) {
            $defaultKetuaInstansi = 'Universitas Negeri Jakarta';
        }

        $defaultKetuaPekerjaan = $ketuaMember ? ($ketuaMember->getTipeLabel() . ' UNJ') : 'Dosen UNJ';
        $defaultKetuaNoHp = $submission->user?->profile?->no_hp ?? '';
        $defaultKetuaEmail = $submission->user?->email ?? '';

        $defaultAnggotaList = [];
        foreach ($anggotaMembers as $m) {
            $roleLabel = $m->getTipeLabel() ?? 'Anggota Tim';
            $inst = $m->institusi_fakultas ? ' / ' . $m->institusi_fakultas : ' / Dosen UNJ';
            $defaultAnggotaList[] = $m->nama_lengkap . $inst;
        }

        $lembarPengesahanInitial = [
            'judul_inovasi' => $submission->identitas?->nama_produk ?? ('Proposal: ' . ($submission->session?->nama_sesi ?? 'Inovasi')),
            'kategori_focus_challenge' => $submission->tema_label ?? $submission->tema ?? ($submission->session?->nama_sesi ?? 'DeepTech Challenge'),
            'ketua_nama' => $defaultKetuaNama,
            'ketua_nik_nim_nip' => $defaultKetuaNik,
            'ketua_instansi' => $defaultKetuaInstansi,
            'ketua_pekerjaan' => $defaultKetuaPekerjaan,
            'ketua_no_hp' => $defaultKetuaNoHp,
            'ketua_email' => $defaultKetuaEmail,
            'anggota_tim' => !empty($defaultAnggotaList) ? $defaultAnggotaList : [''],
            'tanggal_tempat' => 'Jakarta, ' . \Carbon\Carbon::now()->translatedFormat('d F Y'),
            'mengetahui_jabatan' => 'Dekan / Pimpinan Instansi',
            'mengetahui_nama' => '',
            'mengetahui_nip' => '',
            'ketua_ttd_nama' => $defaultKetuaNama,
            'ketua_ttd_nip' => $defaultKetuaNik,
        ];

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.show', compact('submission', 'hasReviewer', 'lembarPengesahanInitial'));
    }

    /**
     * Show dedicated Lembar Pengesahan page.
     */
    public function showLembarPengesahan(HackatonSubmission $submission)
    {
        $user = Auth::user();
        $isOwner = $submission->user_id === $user->id;
        $isMember = $submission->members()->where('user_id', $user->id)->exists();
        $isAdmin = in_array($user->role ?? '', ['admin_hackaton', 'superadmin']) || ($user->hasRole('admin_hackaton') ?? false);
        $isReviewer = $submission->reviewers()->where('users.id', $user->id)->exists();

        abort_unless($isOwner || $isMember || $isAdmin || $isReviewer, 403, 'Anda tidak memiliki akses ke proposal ini.');

        $submission->load([
            'session',
            'members.user.profile.fakultas',
            'members.user.profile.prodi',
            'identitas',
            'user.profile.fakultas',
            'user.profile.prodi',
        ]);

        $ketuaMember = $submission->members->firstWhere('peran', 'Ketua');
        $anggotaMembers = $submission->members->where('peran', '!=', 'Ketua')->values();

        $defaultKetuaNama = $ketuaMember?->nama_lengkap ?? $submission->user?->name ?? '';
        $defaultKetuaNik = $ketuaMember?->nik_nim_nip ?? $submission->user?->profile?->identifier_number ?? '';

        $defaultKetuaInstansi = $ketuaMember?->institusi_fakultas;
        if (empty($defaultKetuaInstansi) && $submission->user?->profile) {
            $prodi = $submission->user->profile->prodi?->name;
            $fakultas = $submission->user->profile->fakultas?->name;
            $parts = array_filter([$prodi, $fakultas, 'Universitas Negeri Jakarta']);
            $defaultKetuaInstansi = implode(' / ', $parts);
        }
        if (empty($defaultKetuaInstansi)) {
            $defaultKetuaInstansi = 'Universitas Negeri Jakarta';
        }

        $defaultKetuaPekerjaan = $ketuaMember ? ($ketuaMember->getTipeLabel() . ' UNJ') : 'Dosen UNJ';
        $defaultKetuaNoHp = $submission->user?->profile?->no_hp ?? '';
        $defaultKetuaEmail = $submission->user?->email ?? '';

        $defaultAnggotaList = [];
        foreach ($anggotaMembers as $m) {
            $roleLabel = $m->getTipeLabel() ?? 'Anggota Tim';
            $inst = $m->institusi_fakultas ? ' / ' . $m->institusi_fakultas : ' / Dosen UNJ';
            $defaultAnggotaList[] = $m->nama_lengkap . $inst;
        }

        $lembarInitial = [
            'judul_inovasi' => $submission->identitas?->nama_produk ?? ('Proposal: ' . ($submission->session?->nama_sesi ?? 'Inovasi')),
            'kategori_focus_challenge' => $submission->tema_label ?? $submission->tema ?? ($submission->session?->nama_sesi ?? 'DeepTech Challenge'),
            'ketua_nama' => $defaultKetuaNama,
            'ketua_nik_nim_nip' => $defaultKetuaNik,
            'ketua_instansi' => $defaultKetuaInstansi,
            'ketua_pekerjaan' => $defaultKetuaPekerjaan,
            'ketua_no_hp' => $defaultKetuaNoHp,
            'ketua_email' => $defaultKetuaEmail,
            'anggota_tim' => !empty($defaultAnggotaList) ? $defaultAnggotaList : [''],
            'tanggal_tempat' => 'Jakarta, ' . \Carbon\Carbon::now()->translatedFormat('d F Y'),
            'mengetahui_jabatan' => 'Dekan / Pimpinan Instansi',
            'mengetahui_nama' => '',
            'mengetahui_nip' => '',
            'ketua_ttd_nama' => $defaultKetuaNama,
            'ketua_ttd_nip' => $defaultKetuaNik,
        ];

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.lembar_pengesahan', compact('submission', 'lembarInitial'));
    }

    /**
     * Generate Lembar Pengesahan as PDF.
     */
    public function generateLembarPengesahanPdf(Request $request, HackatonSubmission $submission)
    {
        $user = Auth::user();
        $isOwner = $submission->user_id === $user->id;
        $isMember = $submission->members()->where('user_id', $user->id)->exists();
        $isAdmin = in_array($user->role ?? '', ['admin_hackaton', 'superadmin']) || ($user->hasRole('admin_hackaton') ?? false);
        $isReviewer = $submission->reviewers()->where('users.id', $user->id)->exists();

        abort_unless($isOwner || $isMember || $isAdmin || $isReviewer, 403, 'Anda tidak memiliki akses ke dokumen submission ini.');

        $submission->load([
            'session',
            'identitas',
            'user.profile.fakultas',
            'user.profile.prodi',
            'members.user.profile.fakultas',
            'members.user.profile.prodi',
        ]);

        $ketuaMember = $submission->members->firstWhere('peran', 'Ketua');
        $anggotaMembers = $submission->members->where('peran', '!=', 'Ketua')->values();

        // Defaults from submission if input is empty
        $defaultJudul = $submission->identitas?->nama_produk ?? ('Proposal: ' . ($submission->session?->nama_sesi ?? 'Inovasi'));
        $defaultKategori = $submission->tema_label ?? $submission->tema ?? ($submission->session?->nama_sesi ?? 'Focus Challenge');
        
        $defaultKetuaNama = $ketuaMember?->nama_lengkap ?? $submission->user?->name ?? '';
        $defaultKetuaNik = $ketuaMember?->nik_nim_nip ?? $submission->user?->profile?->identifier_number ?? '';

        $defaultKetuaInstansi = $ketuaMember?->institusi_fakultas;
        if (empty($defaultKetuaInstansi) && $submission->user?->profile) {
            $prodi = $submission->user->profile->prodi?->name;
            $fakultas = $submission->user->profile->fakultas?->name;
            $parts = array_filter([$prodi, $fakultas, 'Universitas Negeri Jakarta']);
            $defaultKetuaInstansi = implode(' / ', $parts);
        }
        if (empty($defaultKetuaInstansi)) {
            $defaultKetuaInstansi = 'Universitas Negeri Jakarta';
        }

        $defaultKetuaPekerjaan = $ketuaMember ? ($ketuaMember->getTipeLabel() . ' UNJ') : 'Dosen UNJ';
        $defaultKetuaNoHp = $submission->user?->profile?->no_hp ?? '';
        $defaultKetuaEmail = $submission->user?->email ?? '';

        $defaultAnggotaList = [];
        foreach ($anggotaMembers as $m) {
            $roleLabel = $m->getTipeLabel() ?? 'Anggota Tim';
            $inst = $m->institusi_fakultas ? ' / ' . $m->institusi_fakultas : ' / Dosen UNJ';
            $defaultAnggotaList[] = $m->nama_lengkap . $inst;
        }

        $judul_inovasi = $request->input('judul_inovasi', $defaultJudul);
        $kategori_focus_challenge = $request->input('kategori_focus_challenge', $defaultKategori);

        $ketua_nama = $request->input('ketua_nama', $defaultKetuaNama);
        $ketua_nik_nim_nip = $request->input('ketua_nik_nim_nip', $defaultKetuaNik);
        $ketua_instansi = $request->input('ketua_instansi', $defaultKetuaInstansi);
        $ketua_pekerjaan = $request->input('ketua_pekerjaan', $defaultKetuaPekerjaan);
        $ketua_no_hp = $request->input('ketua_no_hp', $defaultKetuaNoHp);
        $ketua_email = $request->input('ketua_email', $defaultKetuaEmail);

        $rawAnggota = $request->input('anggota_tim');
        if (is_array($rawAnggota)) {
            $anggota_tim = array_values(array_filter(array_map('trim', $rawAnggota), fn($val) => filled($val)));
        } else {
            $anggota_tim = $defaultAnggotaList;
        }

        $tanggal_tempat = $request->input('tanggal_tempat', 'Jakarta, ' . \Carbon\Carbon::now()->translatedFormat('d F Y'));

        $mengetahui_jabatan = $request->input('mengetahui_jabatan', 'Dekan / Pimpinan Instansi');
        $mengetahui_nama = $request->input('mengetahui_nama', '');
        $mengetahui_nip = $request->input('mengetahui_nip', '');

        $ketua_ttd_nama = $request->input('ketua_ttd_nama', $ketua_nama);
        $ketua_ttd_nip = $request->input('ketua_ttd_nip', $ketua_nik_nim_nip);

        // Base64 Logo UNJ for PDF
        $logoBase64 = null;
        $logoPath = public_path('images/logos/Logo Baru UNJ.png');
        if (!file_exists($logoPath)) {
            $logoPath = public_path('images/logoditisip.png');
        }
        if (file_exists($logoPath)) {
            $mime = mime_content_type($logoPath) ?: 'image/png';
            $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        $data = compact(
            'submission',
            'judul_inovasi',
            'kategori_focus_challenge',
            'ketua_nama',
            'ketua_nik_nim_nip',
            'ketua_instansi',
            'ketua_pekerjaan',
            'ketua_no_hp',
            'ketua_email',
            'anggota_tim',
            'tanggal_tempat',
            'mengetahui_jabatan',
            'mengetahui_nama',
            'mengetahui_nip',
            'ketua_ttd_nama',
            'ketua_ttd_nip',
            'logoBase64'
        );

        $pdf = Pdf::loadView('subdirektorat-inovasi.hackaton.pengusul.submissions.lembar_pengesahan_pdf', $data);
        $pdf->setPaper('a4', 'portrait');

        $safeTitle = Str::slug($judul_inovasi ?: 'Proposal-Hackathon', '-');
        $filename = 'Lembar-Pengesahan-' . ($safeTitle ?: 'Hackathon') . '.pdf';

        if ($request->has('download') && $request->input('download') == '1') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    /**
     * Show identitas tim page.
     */
    public function showIdentitas(HackatonSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $user = Auth::user()->load('profile.fakultas', 'profile.prodi');
        $submission->load(['session', 'identitas', 'members.user.profile.fakultas', 'members.user.profile.prodi']);

        $fakultasName = $user->profile?->fakultas?->name ?? '-';
        $prodiName    = $user->profile?->prodi?->name ?? '-';
        $ketuaName    = $user->name;

        $session = $submission->session;
        $minAnggota = $session->min_anggota ?? 1;
        $maxAnggota = $session->max_anggota ?? 4;
        $currentCount = $submission->members->count();

        $skemaOptions = [
            'Hilirisasi Produk Riset Inovasi',
            'Hilirisasi Produk Kolaborasi Dosen dan Alumni',
            'Hibah Komersialisasi Produk / Jasa Kepakaran Dosen (Income generating)',
            'Kolaborasi DUDI (Industri)',
        ];

        return view(
            'subdirektorat-inovasi.hackaton.pengusul.submissions.identitas',
            compact('submission', 'fakultasName', 'prodiName', 'ketuaName', 'skemaOptions', 'minAnggota', 'maxAnggota', 'currentCount')
        );
    }

    /**
     * Save identitas tim.
     */
    public function saveIdentitas(Request $request, HackatonSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nama_produk'         => 'required|string|max:255',
            'skema_inovasi'       => 'required|string|max:255',
            'bidang_utama_produk' => 'required|string|max:255',
        ]);

        HackatonSubmissionIdentitas::updateOrCreate(
            ['hackaton_submission_id' => $submission->id],
            $validated
        );

        if ($request->filled('tema')) {
            $submission->update(['tema' => $request->tema]);
        }

        return back()->with('success', 'Identitas inovasi berhasil disimpan.');
    }

    /**
     * Show a specific Tahap form.
     */
    public function showTahap(HackatonSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submissionTahap = HackatonSubmissionTahap::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        $fieldValues = HackatonSubmissionFieldValue::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->get()
            ->keyBy('hackaton_tahap_field_id');

        $submission->load('session');

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.tahap', compact('submission', 'submissionTahap', 'fieldValues'));
    }

    /**
     * Save Tahap as draft.
     */
    public function saveTahap(Request $request, HackatonSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submissionTahap = HackatonSubmissionTahap::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->firstOrFail();

        abort_unless($submissionTahap->isEditable(), 403, 'Tahap ini tidak dapat diedit saat ini.');

        $this->persistFieldValues($request, $submission, $tahapId);

        $submissionTahap->update(['status' => 'draft']);

        return back()->with('success', 'Draf berhasil disimpan.');
    }

    /**
     * Submit Tahap final.
     */
    public function submitTahap(Request $request, HackatonSubmission $submission, $tahapId)
    {
        abort_if($submission->user_id !== Auth::id(), 403);

        $submissionTahap = HackatonSubmissionTahap::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->firstOrFail();

        abort_unless($submissionTahap->isEditable(), 403, 'Tahap ini tidak dapat disubmit saat ini.');

        $this->persistFieldValues($request, $submission, $tahapId);

        $submissionTahap->update([
            'status'       => 'diajukan',
            'submitted_at' => now(),
            'admin_status' => 'menunggu',
        ]);

        $submission->update(['status' => 'diajukan']);

        $tahapKe = $submissionTahap->tahap->tahap_ke ?? '?';
        HackatonStatusLog::logTahapStatus(
            $submission->id,
            $tahapId,
            'draft',
            'diajukan',
            "Tahap {$tahapKe} diajukan oleh pengusul",
            Auth::id(),
            Auth::user()->role
        );

        return redirect()
            ->route('hackaton.submissions.show', $submission)
            ->with('success', "Tahap {$tahapKe} berhasil diajukan.");
    }

    /**
     * Helper to save uploaded files & field values.
     */
    private function persistFieldValues(Request $request, HackatonSubmission $submission, int $tahapId): void
    {
        $fields = \App\Models\HackatonTahapField::where('hackaton_tahap_id', $tahapId)->get();

        foreach ($fields as $field) {
            $key = "field_{$field->id}";

            if ($field->field_type === 'file') {
                if ($request->hasFile($key)) {
                    $file = $request->file($key);
                    $path = $file->store("hackaton/submissions/{$submission->id}/tahap_{$tahapId}", 'public');

                    HackatonSubmissionFieldValue::updateOrCreate(
                        [
                            'hackaton_submission_id'  => $submission->id,
                            'hackaton_tahap_id'       => $tahapId,
                            'hackaton_tahap_field_id' => $field->id,
                        ],
                        ['value' => $path]
                    );
                }
            } elseif ($field->field_type === 'checkbox') {
                $rawVals = $request->input($key, []);
                $val = is_array($rawVals) ? json_encode(array_values($rawVals)) : null;

                HackatonSubmissionFieldValue::updateOrCreate(
                    [
                        'hackaton_submission_id'  => $submission->id,
                        'hackaton_tahap_id'       => $tahapId,
                        'hackaton_tahap_field_id' => $field->id,
                    ],
                    ['value' => $val]
                );
            } else {
                if ($request->has($key)) {
                    HackatonSubmissionFieldValue::updateOrCreate(
                        [
                            'hackaton_submission_id'  => $submission->id,
                            'hackaton_tahap_id'       => $tahapId,
                            'hackaton_tahap_field_id' => $field->id,
                        ],
                        ['value' => $request->input($key)]
                    );
                }
            }
        }
    }

    /**
     * Team submissions where the user is an Anggota (not Ketua).
     */
    public function memberSubmissions()
    {
        $memberOf = HackatonSubmissionMember::where('user_id', Auth::id())
            ->where('peran', '!=', 'Ketua')
            ->with(['submission.session', 'submission.submissionTahap.tahap', 'submission.user', 'submission.members'])
            ->latest()
            ->paginate(10);

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.member-index', compact('memberOf'));
    }

    /**
     * Read-only view for member.
     */
    public function showMemberSubmission(HackatonSubmission $submission)
    {
        $member = HackatonSubmissionMember::where('hackaton_submission_id', $submission->id)
            ->where('user_id', Auth::id())
            ->where('peran', '!=', 'Ketua')
            ->first();

        abort_if(!$member, 403, 'Anda bukan anggota tim dari proposal ini.');
        abort_if($member->approval_status === 'pending', 403, 'Anda belum menerima undangan perkumpulan ini.');
        abort_if($member->approval_status === 'rejected', 403, 'Anda sudah menolak undangan ini.');

        $submission->load([
            'session',
            'submissionTahap.tahap',
            'members.user',
            'identitas',
            'reviewers',
            'reviews.reviewer',
            'reviews.tahap',
            'statusLogs.tahap',
            'statusLogs.causer',
        ]);

        $hasReviewer = $submission->reviewers->isNotEmpty();

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.member-show', compact('submission', 'hasReviewer'));
    }

    /**
     * Show a tahap read-only for member.
     */
    public function showMemberTahap(HackatonSubmission $submission, $tahapId)
    {
        $member = HackatonSubmissionMember::where('hackaton_submission_id', $submission->id)
            ->where('user_id', Auth::id())
            ->where('peran', '!=', 'Ketua')
            ->first();

        abort_if(!$member, 403, 'Anda bukan anggota tim dari proposal ini.');
        abort_if(!in_array($member->approval_status, ['approved', 'not_required']), 403, 'Anda belum memiliki akses ke proposal ini.');

        $submissionTahap = HackatonSubmissionTahap::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->firstOrFail();

        $submissionTahap->load(['tahap.sections.fields', 'tahap.unsectionedFields']);

        $fieldValues = HackatonSubmissionFieldValue::where('hackaton_submission_id', $submission->id)
            ->where('hackaton_tahap_id', $tahapId)
            ->get()
            ->keyBy('hackaton_tahap_field_id');

        $submission->load('session');

        return view('subdirektorat-inovasi.hackaton.pengusul.submissions.tahap', [
            'submission'      => $submission,
            'submissionTahap' => $submissionTahap,
            'fieldValues'     => $fieldValues,
            'isReadOnly'      => true,
        ]);
    }
}

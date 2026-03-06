<?php

namespace App\Http\Controllers\EquityFakultas;

use App\Http\Controllers\Controller;
use App\Models\EmployerMeetingSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployerMeetingController extends Controller
{
    public function index()
    {
        $submissions = EmployerMeetingSubmission::where('user_id', Auth::id())->latest()->paginate(10);
        return view('equity_fakultas.employer_meetings.index', compact('submissions'));
    }

    public function create()
    {
        return view('equity_fakultas.employer_meetings.create');
    }

    /**
     * Menampilkan detail proposal
     */
    public function show(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.employer_meetings.show', ['submission' => $employerMeeting]);
    }

    /**
     * Menyimpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf,xlsx,xls|max:5120',
        ]);

        $proposalFile = $request->file('proposal_file');
        $proposalName = 'employer-meetings_' . Str::slug(Auth::user()->name) . '_proposal_' . now()->format('Ymd_His') . '.' . $proposalFile->getClientOriginalExtension();
        $path = $proposalFile->storeAs('employer_meetings', $proposalName, 'public');

        EmployerMeetingSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
            'is_confirmed' => false,
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil diajukan. Silakan konfirmasi untuk mengirim ke admin.');
    }

    /**
     * Edit proposal yang masih dalam status diajukan (sebelum dikonfirmasi)
     */
    public function editDraft(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.employer_meetings.edit_draft', ['submission' => $employerMeeting]);
    }

    /**
     * Update proposal yang masih draft
     */
    public function updateDraft(Request $request, EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'nullable|file|mimes:pdf,xlsx,xls|max:5120',
        ]);

        $data = ['nama_pengunggah' => $request->nama_pengunggah];

        if ($request->hasFile('proposal_file')) {
            if ($employerMeeting->proposal_path) {
                Storage::disk('public')->delete($employerMeeting->proposal_path);
            }
            $pFile = $request->file('proposal_file');
            $pName = 'employer-meetings_' . Str::slug(Auth::user()->name) . '_proposal_' . now()->format('Ymd_His') . '.' . $pFile->getClientOriginalExtension();
            $data['proposal_path'] = $pFile->storeAs('employer_meetings', $pName, 'public');
        }

        $employerMeeting->update($data);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    /**
     * Hapus proposal yang masih draft
     */
    public function destroy(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        if ($employerMeeting->proposal_path) {
            Storage::disk('public')->delete($employerMeeting->proposal_path);
        }

        $employerMeeting->delete();

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil dihapus.');
    }

    /**
     * Konfirmasi pengajuan untuk dikirim ke admin
     */
    public function confirm(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || $employerMeeting->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $employerMeeting->update([
            'is_confirmed' => true,
            'status' => 'menunggu diverifikasi',
        ]);

        return redirect()->route('equity_fakultas.employer-meetings.index')->with('success', 'Proposal berhasil dikirim dan menunggu verifikasi admin.');
    }

    /**
     * Menampilkan form untuk melengkapi data (setelah disetujui admin).
     */
    public function edit(EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || !in_array($employerMeeting->status, ['disetujui', 'selesai'])) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.employer_meetings.edit', ['submission' => $employerMeeting]);
    }

    /**
     * Menyimpan data tambahan (bukti keuangan & nama responden).
     * Mendukung save_type: 'draft' (simpan sebagian) atau 'final' (selesaikan).
     */
    public function update(Request $request, EmployerMeetingSubmission $employerMeeting)
    {
        if ($employerMeeting->user_id !== Auth::id() || !in_array($employerMeeting->status, ['disetujui', 'selesai'])) {
            abort(403, 'Akses Ditolak');
        }

        $isReEdit  = $employerMeeting->status === 'selesai';
        $saveAsDraft = !$isReEdit && $request->input('save_type') === 'draft';

        if ($saveAsDraft) {
            // Draft: semua file opsional — simpan apa yang diunggah saja
            $request->validate([
                'bukti_keuangan_file'  => 'nullable|file|mimes:pdf|max:5120',
                'laporan_kegiatan_file' => 'nullable|file|mimes:pdf|max:5120',
                'nama_qs_file'          => 'nullable|file|mimes:xlsx,xls|max:5120',
            ]);
        } else {
            // Final atau re-edit: file wajib jika belum ada file sebelumnya
            $request->validate([
                'bukti_keuangan_file'  => ($isReEdit || $employerMeeting->bukti_keuangan_path  ? 'nullable' : 'required') . '|file|mimes:pdf|max:5120',
                'laporan_kegiatan_file' => ($isReEdit || $employerMeeting->laporan_kegiatan_path ? 'nullable' : 'required') . '|file|mimes:pdf|max:5120',
                'nama_qs_file'          => ($isReEdit || $employerMeeting->nama_qs_path          ? 'nullable' : 'required') . '|file|mimes:xlsx,xls|max:5120',
            ]);
        }

        $updateData = [];
        $userSlug = Str::slug(Auth::user()->name);

        // Update Bukti Keuangan jika ada file baru
        if ($request->hasFile('bukti_keuangan_file')) {
            if ($employerMeeting->bukti_keuangan_path) {
                Storage::disk('public')->delete($employerMeeting->bukti_keuangan_path);
            }
            $bkFile = $request->file('bukti_keuangan_file');
            $bkName = 'employer-meetings_' . $userSlug . '_bukti-keuangan_' . now()->format('Ymd_His') . '.' . $bkFile->getClientOriginalExtension();
            $updateData['bukti_keuangan_path'] = $bkFile->storeAs('employer_meetings', $bkName, 'public');
        }

        // Update Laporan Kegiatan jika ada file baru
        if ($request->hasFile('laporan_kegiatan_file')) {
            if ($employerMeeting->laporan_kegiatan_path) {
                Storage::disk('public')->delete($employerMeeting->laporan_kegiatan_path);
            }
            $lkFile = $request->file('laporan_kegiatan_file');
            $lkName = 'employer-meetings_' . $userSlug . '_laporan-kegiatan_' . now()->format('Ymd_His') . '.' . $lkFile->getClientOriginalExtension();
            $updateData['laporan_kegiatan_path'] = $lkFile->storeAs('employer_meetings', $lkName, 'public');
        }

        // Update Data QS jika ada file baru
        if ($request->hasFile('nama_qs_file')) {
            if ($employerMeeting->nama_qs_path) {
                Storage::disk('public')->delete($employerMeeting->nama_qs_path);
            }
            $qsFile = $request->file('nama_qs_file');
            $qsName = 'employer-meetings_' . $userSlug . '_data-qs_' . now()->format('Ymd_His') . '.' . $qsFile->getClientOriginalExtension();
            $updateData['nama_qs_path'] = $qsFile->storeAs('employer_meetings', $qsName, 'public');
        }

        // Hanya ubah status ke selesai jika bukan draft dan belum selesai
        if (!$saveAsDraft && !$isReEdit) {
            $updateData['status'] = 'selesai';
        }

        if (!empty($updateData)) {
            $employerMeeting->update($updateData);
        }

        if ($saveAsDraft) {
            return redirect()->route('equity_fakultas.employer-meetings.index')
                ->with('success', 'Data berhasil disimpan sebagai draft. Silakan lengkapi file yang belum diunggah.');
        }

        return redirect()->route('equity_fakultas.employer-meetings.index')
            ->with('success', 'Data proposal berhasil dilengkapi.');
    }
}
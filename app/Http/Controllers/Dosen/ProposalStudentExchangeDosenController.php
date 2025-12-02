<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\SesiStudentExchange;
use App\Models\ProposalStudentExchange;
use App\Models\StudentExchangeMitra;
use App\Models\AnggotaStudentExchange;
use App\Models\StudentExchangeModul;
use App\Models\StudentExchangeSubChapter;
use App\Models\StudentExchangeSubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProposalStudentExchangeDosenController extends Controller
{
    /**
     * Display list of open Student Exchange sessions.
     */
    public function listSesi()
    {
        $sessions = SesiStudentExchange::where('status', 'dibuka')
            ->where('periode_akhir', '>=', now())
            ->orderBy('periode_awal', 'desc')
            ->get();
        
        return view('subdirektorat-inovasi.dosen.student_exchange.list_sesi', compact('sessions'));
    }

    /**
     * Display dosen's own proposals across all sessions.
     */
    public function manageProposals()
    {
        $proposals = ProposalStudentExchange::where('user_id', Auth::id())
            ->with(['sesi', 'mitra', 'anggota', 'reviewer'])
            ->latest()
            ->paginate(10);
        
        return view('subdirektorat-inovasi.dosen.student_exchange.manage_proposals', compact('proposals'));
    }

    /**
     * Show the form for creating a new proposal.
     */
    public function createForm(SesiStudentExchange $sesi)
    {
        // Check if session is open
        if ($sesi->status !== 'dibuka' || $sesi->periode_akhir < now()) {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.sesi')
                ->with('error', 'Sesi ini sudah ditutup atau belum dibuka.');
        }

        return view('subdirektorat-inovasi.dosen.student_exchange.create_proposal', compact('sesi'));
    }

    /**
     * Store a newly created proposal.
     */
    public function store(Request $request, SesiStudentExchange $sesi)
    {
        // Validation
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'ringkasan_kegiatan' => 'required|string|max:300',
            'sdgs_fokus' => 'nullable|json',
            'sdgs_pendukung' => 'nullable|json',
            'jenis_kegiatan' => 'required|in:inbound,outbound',
            'jumlah_peserta' => 'required|integer|min:1',
            'sks' => 'required|integer|min:1',
            'nama_mahasiswa' => 'required|file|mimes:pdf,xlsx,xls|max:10240',
            'mata_kuliah' => 'required|file|mimes:pdf|max:10240',
            'rab' => 'required|file|mimes:pdf,xlsx,xls|max:10240',
            'tanggal_online' => 'nullable|date',
            'tanggal_onsite' => 'nullable|date',
            
            // Mitra fields
            'nama_mitra' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'nomor_kontak_pic' => 'required|string|max:50',
            'email_pic' => 'required|email|max:255',
            'kesediaan_mitra' => 'required|file|mimes:pdf|max:10240',
            
            // Anggota fields
            'anggota' => 'nullable|array',
            'anggota.*.nama_dosen' => 'required_with:anggota|string|max:255',
            'anggota.*.nip' => 'nullable|string|max:50',
            'anggota.*.fakultas' => 'nullable|string|max:255',
            'anggota.*.prodi' => 'nullable|string|max:255',
        ], [
            'judul_kegiatan.required' => 'Judul kegiatan wajib diisi.',
            'ringkasan_kegiatan.required' => 'Ringkasan kegiatan wajib diisi.',
            'ringkasan_kegiatan.max' => 'Ringkasan kegiatan maksimal 300 karakter.',
            'jenis_kegiatan.required' => 'Jenis kegiatan wajib dipilih.',
            'jenis_kegiatan.in' => 'Jenis kegiatan harus inbound atau outbound.',
            'jumlah_peserta.required' => 'Jumlah peserta wajib diisi.',
            'jumlah_peserta.integer' => 'Jumlah peserta harus berupa angka.',
            'sks.required' => 'SKS wajib diisi.',
            'nama_mahasiswa.required' => 'File daftar nama mahasiswa wajib diunggah.',
            'nama_mahasiswa.mimes' => 'File daftar nama mahasiswa harus berformat PDF atau Excel.',
            'nama_mahasiswa.max' => 'Ukuran file daftar nama mahasiswa maksimal 10MB.',
            'mata_kuliah.required' => 'File mata kuliah wajib diunggah.',
            'mata_kuliah.mimes' => 'File mata kuliah harus berformat PDF.',
            'rab.required' => 'File RAB wajib diunggah.',
            'rab.mimes' => 'File RAB harus berformat PDF atau Excel.',
            'nama_mitra.required' => 'Nama mitra wajib diisi.',
            'negara.required' => 'Negara mitra wajib diisi.',
            'nama_pic.required' => 'Nama PIC mitra wajib diisi.',
            'nomor_kontak_pic.required' => 'Nomor kontak PIC wajib diisi.',
            'email_pic.required' => 'Email PIC wajib diisi.',
            'email_pic.email' => 'Format email PIC tidak valid.',
            'kesediaan_mitra.required' => 'File kesediaan mitra wajib diunggah.',
            'kesediaan_mitra.mimes' => 'File kesediaan mitra harus berformat PDF.',
        ]);

        // Check if at least one date is provided
        if (!$request->tanggal_online && !$request->tanggal_onsite) {
            return back()->withErrors(['tanggal_online' => 'Minimal salah satu tanggal (online atau onsite) harus diisi.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Decode JSON input helper function
            $decodeJsonInput = function ($jsonString) {
                if (empty($jsonString)) return null;
                $data = json_decode($jsonString, true);
                if (is_array($data) && !empty($data) && isset($data[0]['value'])) {
                    return array_column($data, 'value');
                }
                return $data;
            };

            // Create proposal
            $proposal = new ProposalStudentExchange();
            $proposal->sesi_student_exchange_id = $sesi->id;
            $proposal->user_id = Auth::id();
            $proposal->judul_kegiatan = $request->judul_kegiatan;
            $proposal->ringkasan_kegiatan = $request->ringkasan_kegiatan;
            $proposal->sdgs_fokus = $decodeJsonInput($request->sdgs_fokus);
            $proposal->sdgs_pendukung = $decodeJsonInput($request->sdgs_pendukung);
            $proposal->jenis_kegiatan = $request->jenis_kegiatan;
            $proposal->jumlah_peserta = $request->jumlah_peserta;
            $proposal->sks = $request->sks;
            $proposal->tanggal_online = $request->tanggal_online;
            $proposal->tanggal_onsite = $request->tanggal_onsite;
            $proposal->status = 'draft';
            $proposal->save();

            // Create directory for this proposal
            $proposalDir = "student_exchange/proposals/{$proposal->id}";
            
            // Upload files
            if ($request->hasFile('nama_mahasiswa')) {
                $proposal->nama_mahasiswa_path = $request->file('nama_mahasiswa')
                    ->store($proposalDir, 'public');
            }
            
            if ($request->hasFile('mata_kuliah')) {
                $proposal->mata_kuliah_path = $request->file('mata_kuliah')
                    ->store($proposalDir, 'public');
            }
            
            if ($request->hasFile('rab')) {
                $proposal->rab_path = $request->file('rab')
                    ->store($proposalDir, 'public');
            }
            
            $proposal->save();

            // Save mitra data
            $mitra = new StudentExchangeMitra();
            $mitra->proposal_student_exchange_id = $proposal->id;
            $mitra->nama_mitra = $request->nama_mitra;
            $mitra->negara = $request->negara;
            $mitra->nama_pic = $request->nama_pic;
            $mitra->nomor_kontak_pic = $request->nomor_kontak_pic;
            $mitra->email_pic = $request->email_pic;
            
            if ($request->hasFile('kesediaan_mitra')) {
                $mitra->kesediaan_mitra_path = $request->file('kesediaan_mitra')
                    ->store($proposalDir, 'public');
            }
            
            $mitra->save();

            // Save anggota
            if ($request->has('anggota') && is_array($request->anggota)) {
                foreach ($request->anggota as $index => $anggotaData) {
                    if (!empty($anggotaData['nama_dosen'])) {
                        AnggotaStudentExchange::create([
                            'proposal_student_exchange_id' => $proposal->id,
                            'nama_dosen' => $anggotaData['nama_dosen'],
                            'nip' => $anggotaData['nip'] ?? null,
                            'fakultas' => $anggotaData['fakultas'] ?? null,
                            'prodi' => $anggotaData['prodi'] ?? null,
                            'urutan' => $index + 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('success', 'Proposal berhasil dibuat. Status: Draft.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating Student Exchange proposal: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan proposal.'])
                ->withInput();
        }
    }

    /**
     * Display the specified proposal.
     */
    public function show(ProposalStudentExchange $proposal)
    {
        // Authorization: Only the owner can view
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        $proposal->load(['sesi', 'mitra', 'anggota', 'reviewer', 'submissionFiles.subChapter']);

        return view('subdirektorat-inovasi.dosen.student_exchange.show_proposal', compact('proposal'));
    }

    /**
     * Show the form for editing the specified proposal.
     */
    public function edit(ProposalStudentExchange $proposal)
    {
        // Authorization: Only the owner can edit
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        // Only draft and diajukan can be edited
        if (!in_array($proposal->status, ['draft', 'diajukan'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Proposal dengan status ini tidak dapat diedit.');
        }

        $proposal->load(['sesi', 'mitra', 'anggota']);

        return view('subdirektorat-inovasi.dosen.student_exchange.edit_proposal', compact('proposal'));
    }

    /**
     * Update the specified proposal.
     */
    public function update(Request $request, ProposalStudentExchange $proposal)
    {
        // Authorization
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        // Only draft and diajukan can be updated
        if (!in_array($proposal->status, ['draft', 'diajukan'])) {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Proposal dengan status ini tidak dapat diubah.');
        }

        // Validation
        $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'ringkasan_kegiatan' => 'required|string|max:300',
            'sdgs_fokus' => 'nullable|json',
            'sdgs_pendukung' => 'nullable|json',
            'jenis_kegiatan' => 'required|in:inbound,outbound',
            'jumlah_peserta' => 'required|integer|min:1',
            'sks' => 'required|integer|min:1',
            'nama_mahasiswa' => 'nullable|file|mimes:pdf,xlsx,xls|max:10240',
            'mata_kuliah' => 'nullable|file|mimes:pdf|max:10240',
            'rab' => 'nullable|file|mimes:pdf,xlsx,xls|max:10240',
            'tanggal_online' => 'nullable|date',
            'tanggal_onsite' => 'nullable|date',
            
            // Mitra fields
            'nama_mitra' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'nama_pic' => 'required|string|max:255',
            'nomor_kontak_pic' => 'required|string|max:50',
            'email_pic' => 'required|email|max:255',
            'kesediaan_mitra' => 'nullable|file|mimes:pdf|max:10240',
            
            // Anggota fields
            'anggota' => 'nullable|array',
            'anggota.*.nama_dosen' => 'required_with:anggota|string|max:255',
            'anggota.*.nip' => 'nullable|string|max:50',
            'anggota.*.fakultas' => 'nullable|string|max:255',
            'anggota.*.prodi' => 'nullable|string|max:255',
        ]);

        // Check if at least one date is provided
        if (!$request->tanggal_online && !$request->tanggal_onsite) {
            return back()->withErrors(['tanggal_online' => 'Minimal salah satu tanggal (online atau onsite) harus diisi.'])
                ->withInput();
        }

        DB::beginTransaction();
        try {
            // Decode JSON input helper function
            $decodeJsonInput = function ($jsonString) {
                if (empty($jsonString)) return null;
                $data = json_decode($jsonString, true);
                if (is_array($data) && !empty($data) && isset($data[0]['value'])) {
                    return array_column($data, 'value');
                }
                return $data;
            };

            // Update proposal
            $proposal->judul_kegiatan = $request->judul_kegiatan;
            $proposal->ringkasan_kegiatan = $request->ringkasan_kegiatan;
            $proposal->sdgs_fokus = $decodeJsonInput($request->sdgs_fokus);
            $proposal->sdgs_pendukung = $decodeJsonInput($request->sdgs_pendukung);
            $proposal->jenis_kegiatan = $request->jenis_kegiatan;
            $proposal->jumlah_peserta = $request->jumlah_peserta;
            $proposal->sks = $request->sks;
            $proposal->tanggal_online = $request->tanggal_online;
            $proposal->tanggal_onsite = $request->tanggal_onsite;

            // Create directory for this proposal
            $proposalDir = "student_exchange/proposals/{$proposal->id}";
            
            // Update files if new ones are uploaded
            if ($request->hasFile('nama_mahasiswa')) {
                // Delete old file
                if ($proposal->nama_mahasiswa_path) {
                    Storage::disk('public')->delete($proposal->nama_mahasiswa_path);
                }
                $proposal->nama_mahasiswa_path = $request->file('nama_mahasiswa')
                    ->store($proposalDir, 'public');
            }
            
            if ($request->hasFile('mata_kuliah')) {
                if ($proposal->mata_kuliah_path) {
                    Storage::disk('public')->delete($proposal->mata_kuliah_path);
                }
                $proposal->mata_kuliah_path = $request->file('mata_kuliah')
                    ->store($proposalDir, 'public');
            }
            
            if ($request->hasFile('rab')) {
                if ($proposal->rab_path) {
                    Storage::disk('public')->delete($proposal->rab_path);
                }
                $proposal->rab_path = $request->file('rab')
                    ->store($proposalDir, 'public');
            }
            
            $proposal->save();

            // Update mitra data
            $mitra = $proposal->mitra;
            if (!$mitra) {
                $mitra = new StudentExchangeMitra();
                $mitra->proposal_student_exchange_id = $proposal->id;
            }
            
            $mitra->nama_mitra = $request->nama_mitra;
            $mitra->negara = $request->negara;
            $mitra->nama_pic = $request->nama_pic;
            $mitra->nomor_kontak_pic = $request->nomor_kontak_pic;
            $mitra->email_pic = $request->email_pic;
            
            if ($request->hasFile('kesediaan_mitra')) {
                if ($mitra->kesediaan_mitra_path) {
                    Storage::disk('public')->delete($mitra->kesediaan_mitra_path);
                }
                $mitra->kesediaan_mitra_path = $request->file('kesediaan_mitra')
                    ->store($proposalDir, 'public');
            }
            
            $mitra->save();

            // Update anggota - delete old and create new
            AnggotaStudentExchange::where('proposal_student_exchange_id', $proposal->id)->delete();
            
            if ($request->has('anggota') && is_array($request->anggota)) {
                foreach ($request->anggota as $index => $anggotaData) {
                    if (!empty($anggotaData['nama_dosen'])) {
                        AnggotaStudentExchange::create([
                            'proposal_student_exchange_id' => $proposal->id,
                            'nama_dosen' => $anggotaData['nama_dosen'],
                            'nip' => $anggotaData['nip'] ?? null,
                            'fakultas' => $anggotaData['fakultas'] ?? null,
                            'prodi' => $anggotaData['prodi'] ?? null,
                            'urutan' => $index + 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('success', 'Proposal berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating Student Exchange proposal: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui proposal.'])
                ->withInput();
        }
    }

    /**
     * Confirm proposal - change status to menunggu_verifikasi.
     */
    public function confirm(ProposalStudentExchange $proposal)
    {
        // Authorization
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        // Only draft can be confirmed
        if ($proposal->status !== 'draft') {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Hanya proposal dengan status draft yang dapat dikonfirmasi.');
        }

        // Check if all required data is complete
        if (!$proposal->nama_mahasiswa_path || !$proposal->mata_kuliah_path || !$proposal->rab_path) {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Semua file wajib harus diunggah sebelum mengajukan proposal.');
        }

        if (!$proposal->mitra) {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Data mitra harus dilengkapi sebelum mengajukan proposal.');
        }

        $proposal->status = 'diajukan';
        $proposal->save();

        return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
            ->with('success', 'Proposal berhasil diajukan dan menunggu verifikasi admin.');
    }

    /**
     * Delete the specified proposal (only draft).
     */
    public function destroy(ProposalStudentExchange $proposal)
    {
        // Authorization
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        // Only draft can be deleted
        if ($proposal->status !== 'draft') {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.manage')
                ->with('error', 'Hanya proposal dengan status draft yang dapat dihapus.');
        }

        DB::beginTransaction();
        try {
            // Delete files
            $filesToDelete = [
                $proposal->nama_mahasiswa_path,
                $proposal->mata_kuliah_path,
                $proposal->rab_path,
            ];

            if ($proposal->mitra && $proposal->mitra->kesediaan_mitra_path) {
                $filesToDelete[] = $proposal->mitra->kesediaan_mitra_path;
            }

            foreach ($filesToDelete as $filePath) {
                if ($filePath) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            // Delete directory
            $proposalDir = "student_exchange/proposals/{$proposal->id}";
            Storage::disk('public')->deleteDirectory($proposalDir);

            // Delete related records (cascade should handle this, but explicitly for safety)
            $proposal->mitra()->delete();
            $proposal->anggota()->delete();
            $proposal->submissionFiles()->delete();
            $proposal->delete();

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.manage')
                ->with('success', 'Proposal berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting Student Exchange proposal: ' . $e->getMessage());
            
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.manage')
                ->with('error', 'Terjadi kesalahan saat menghapus proposal.');
        }
    }

    /**
     * Show final module submission form (laporan akhir).
     */
    public function laporanAkhir(ProposalStudentExchange $proposal)
    {
        // Authorization
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        // Only lolos status can submit final report
        if ($proposal->status !== 'lolos') {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Laporan akhir hanya dapat diisi untuk proposal yang lolos.');
        }

        // Load modules with subchapters
        $moduls = StudentExchangeModul::where('sesi_student_exchange_id', $proposal->sesi_student_exchange_id)
            ->with(['subChapters' => function ($query) {
                $query->orderBy('urutan');
            }])
            ->orderBy('urutan')
            ->get();

        // Load existing submissions
        $existingSubmissions = StudentExchangeSubmissionFile::where('proposal_student_exchange_id', $proposal->id)
            ->get()
            ->keyBy('student_exchange_sub_chapter_id');

        return view('subdirektorat-inovasi.dosen.student_exchange.laporan_akhir', compact('proposal', 'moduls', 'existingSubmissions'));
    }

    /**
     * Submit final module files/links.
     */
    public function submitLaporan(Request $request, ProposalStudentExchange $proposal)
    {
        // Authorization
        if ($proposal->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke proposal ini.');
        }

        // Only lolos status can submit final report
        if ($proposal->status !== 'lolos') {
            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('error', 'Laporan akhir hanya dapat diisi untuk proposal yang lolos.');
        }

        // Get all subchapters for this session
        $subChapters = StudentExchangeSubChapter::whereHas('modul', function ($query) use ($proposal) {
            $query->where('sesi_student_exchange_id', $proposal->sesi_student_exchange_id);
        })->get();

        // Validate required subchapters
        $requiredSubChapters = $subChapters->where('is_wajib', true);
        
        foreach ($requiredSubChapters as $subChapter) {
            $hasFile = $request->hasFile("subchapter_{$subChapter->id}_file");
            $hasLink = !empty($request->input("subchapter_{$subChapter->id}_link"));
            
            if ($subChapter->tipe_input === 'pdf' && !$hasFile) {
                return back()->withErrors(['error' => "Sub-chapter wajib '{$subChapter->judul_sub_chapter}' harus diisi (file PDF)."])->withInput();
            }
            
            if ($subChapter->tipe_input === 'link' && !$hasLink) {
                return back()->withErrors(['error' => "Sub-chapter wajib '{$subChapter->judul_sub_chapter}' harus diisi (link URL)."])->withInput();
            }
            
            if ($subChapter->tipe_input === 'both' && !$hasFile && !$hasLink) {
                return back()->withErrors(['error' => "Sub-chapter wajib '{$subChapter->judul_sub_chapter}' harus diisi (file PDF atau link URL)."])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            $submissionDir = "student_exchange/submissions/{$proposal->id}";

            foreach ($subChapters as $subChapter) {
                $hasFile = $request->hasFile("subchapter_{$subChapter->id}_file");
                $hasLink = !empty($request->input("subchapter_{$subChapter->id}_link"));
                $keterangan = $request->input("subchapter_{$subChapter->id}_keterangan");

                // Skip if no input for optional subchapter
                if (!$subChapter->is_wajib && !$hasFile && !$hasLink) {
                    continue;
                }

                // Find or create submission
                $submission = StudentExchangeSubmissionFile::where('proposal_student_exchange_id', $proposal->id)
                    ->where('student_exchange_sub_chapter_id', $subChapter->id)
                    ->first();

                if (!$submission) {
                    $submission = new StudentExchangeSubmissionFile();
                    $submission->proposal_student_exchange_id = $proposal->id;
                    $submission->student_exchange_sub_chapter_id = $subChapter->id;
                }

                // Handle file upload
                if ($hasFile) {
                    // Delete old file if exists
                    if ($submission->file_path) {
                        Storage::disk('public')->delete($submission->file_path);
                    }
                    
                    $submission->file_path = $request->file("subchapter_{$subChapter->id}_file")
                        ->store($submissionDir, 'public');
                    $submission->tipe_file = 'pdf';
                }

                // Handle link
                if ($hasLink) {
                    $submission->link_url = $request->input("subchapter_{$subChapter->id}_link");
                    $submission->tipe_file = $hasFile ? 'both' : 'link';
                }

                $submission->keterangan = $keterangan;
                $submission->save();
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.student_exchange.show', $proposal->id)
                ->with('success', 'Laporan akhir berhasil disubmit.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error submitting Student Exchange final report: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan laporan akhir.'])
                ->withInput();
        }
    }
}

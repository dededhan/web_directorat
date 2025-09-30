<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ApcAuthor;
use App\Models\ApcSession;
use App\Models\ApcSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ApcSubmissionController extends Controller
{
    public function store(Request $request, $sessionId)
    {
        $session = ApcSession::findOrFail($sessionId);

        if ($session->computed_status !== 'Buka') {
            return redirect()->route('subdirektorat-inovasi.dosen.apc.list-sesi')->with('error', 'Sesi pengajuan ini sudah ditutup.');
        }

        $validated = $request->validate([
            'nama_jurnal_q1' => 'required|string|max:255',
            'link_scimagojr' => 'required|url',
            'judul_artikel' => 'required|string',
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'biaya_publikasi' => 'required|numeric|min:0',
            'artikel' => 'required|file|mimes:pdf|max:5120',
            'bukti_invoice' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bukti_submission_proses' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'penulis' => 'required|array|min:1',
            'penulis.*.urutan' => 'required|integer|min:1',
            'penulis.*.nama' => 'required|string|max:255',
            'penulis.*.afiliasi' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::id();
            $userName = Str::slug(Auth::user()->name, '_');
            $timestamp = time();

            $artikelFile = $request->file('artikel');
            $artikelName = "ARTIKEL_{$userName}_{$timestamp}." . $artikelFile->getClientOriginalExtension();
            $artikelPath = $artikelFile->storeAs("apc/submissions/{$userId}", $artikelName, 'public');

            $invoiceFile = $request->file('bukti_invoice');
            $invoiceName = "INVOICE_{$userName}_{$timestamp}." . $invoiceFile->getClientOriginalExtension();
            $invoicePath = $invoiceFile->storeAs("apc/submissions/{$userId}", $invoiceName, 'public');

            $submissionProcessFile = $request->file('bukti_submission_proses');
            $submissionProcessName = "BUKTI_SUBMISSION_{$userName}_{$timestamp}." . $submissionProcessFile->getClientOriginalExtension();
            $submissionProcessPath = $submissionProcessFile->storeAs("apc/submissions/{$userId}", $submissionProcessName, 'public');

            $submission = ApcSubmission::create([
                'apc_session_id' => $sessionId,
                'user_id' => $userId,
                'nama_jurnal_q1' => $validated['nama_jurnal_q1'],
                'link_scimagojr' => $validated['link_scimagojr'],
                'judul_artikel' => $validated['judul_artikel'],
                'volume' => $validated['volume'],
                'issue' => $validated['issue'],
                'biaya_publikasi' => $validated['biaya_publikasi'],
                'artikel_path' => $artikelPath,
                'invoice_path' => $invoicePath,
                'submission_process_path' => $submissionProcessPath,
                'status' => 'diajukan',
            ]);


            $submission->addStatusLog('diajukan', 'Proposal berhasil dibuat oleh pengusul.');
            foreach ($validated['penulis'] as $authorData) {
                $submission->authors()->create($authorData);
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.apc.manajemen')->with('success', 'Proposal APC berhasil diajukan!');
        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($artikelPath) && Storage::disk('public')->exists($artikelPath)) Storage::disk('public')->delete($artikelPath);
            if (isset($invoicePath) && Storage::disk('public')->exists($invoicePath)) Storage::disk('public')->delete($invoicePath);
            if (isset($submissionProcessPath) && Storage::disk('public')->exists($submissionProcessPath)) Storage::disk('public')->delete($submissionProcessPath);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(ApcSubmission $submission)
    {
        $this->authorizeAction($submission);
        $submission->load('authors', 'session');
        return view('subdirektorat-inovasi.dosen.apc.form-edit', compact('submission'));
    }

    public function update(Request $request, ApcSubmission $submission)
    {
        $this->authorizeAction($submission);

        $validated = $request->validate([
            'nama_jurnal_q1' => 'required|string|max:255',
            'link_scimagojr' => 'required|url',
            'judul_artikel' => 'required|string',
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'biaya_publikasi' => 'required|numeric|min:0',
            'artikel' => 'nullable|file|mimes:pdf|max:5120',
            'bukti_invoice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'bukti_submission_proses' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'penulis' => 'required|array|min:1',
            'penulis.*.urutan' => 'required|integer|min:1',
            'penulis.*.nama' => 'required|string|max:255',
            'penulis.*.afiliasi' => 'required|string|max:255',
            'delete_artikel' => 'nullable|boolean',
            'delete_bukti_invoice' => 'nullable|boolean',
            'delete_bukti_submission_proses' => 'nullable|boolean',
        ]);

        try {
            DB::beginTransaction();
            $userId = Auth::id();
            $userName = Str::slug(Auth::user()->name, '_');
            $timestamp = time();

            $dataToUpdate = $validated;
            unset($dataToUpdate['penulis'], $dataToUpdate['artikel'], $dataToUpdate['bukti_invoice'], $dataToUpdate['bukti_submission_proses']);
            unset($dataToUpdate['delete_artikel'], $dataToUpdate['delete_bukti_invoice'], $dataToUpdate['delete_bukti_submission_proses']);

            $fileFields = [
                'artikel' => 'artikel_path',
                'bukti_invoice' => 'invoice_path',
                'bukti_submission_proses' => 'submission_process_path'
            ];

            foreach ($fileFields as $requestKey => $dbColumn) {
                if ($request->hasFile($requestKey)) {
                    if ($submission->$dbColumn) {
                        Storage::disk('public')->delete($submission->$dbColumn);
                    }
                    $file = $request->file($requestKey);
                    $prefix = strtoupper($requestKey);
                    $fileName = "{$prefix}_{$userName}_{$timestamp}." . $file->getClientOriginalExtension();
                    $dataToUpdate[$dbColumn] = $file->storeAs("apc/submissions/{$userId}", $fileName, 'public');
                } elseif ($request->input("delete_{$requestKey}") == '1') {
                    if ($submission->$dbColumn) {
                        Storage::disk('public')->delete($submission->$dbColumn);
                    }
                    $dataToUpdate[$dbColumn] = null;
                }
            }

            $submission->update($dataToUpdate);

            $submission->authors()->delete();
            foreach ($validated['penulis'] as $authorData) {
                $submission->authors()->create($authorData);
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.apc.manajemen')->with('success', 'Proposal berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui proposal: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(ApcSubmission $submission)
    {
        $this->authorizeAction($submission);

        try {
            DB::beginTransaction();

            Storage::disk('public')->delete([
                $submission->artikel_path,
                $submission->invoice_path,
                $submission->submission_process_path
            ]);

            $submission->authors()->delete();
            $submission->delete();

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.apc.manajemen')->with('success', 'Proposal berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('subdirektorat-inovasi.dosen.apc.manajemen')->with('error', 'Gagal menghapus proposal.');
        }
    }


    public function uploadPaymentProof(Request $request, ApcSubmission $submission)
    {
        // 1. Otorisasi: Pastikan dosen adalah pemilik proposal
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // 2. Validasi Status: Hanya boleh upload jika status 'diajukan' atau 'revisi'
        if (!in_array($submission->status, ['diajukan', 'revisi'])) {
            return back()->with('error', 'Tidak dapat mengunggah bukti bayar untuk proposal dengan status saat ini.');
        }

        // 3. Validasi File
        $validated = $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // max 5MB
        ], [
            'bukti_pembayaran.required' => 'Anda harus memilih file bukti pembayaran.',
            'bukti_pembayaran.mimes' => 'Format file harus PDF, JPG, JPEG, atau PNG.',
            'bukti_pembayaran.max' => 'Ukuran file tidak boleh lebih dari 5 MB.',
        ]);

        try {
            DB::beginTransaction();

            $userId = Auth::id();
            $userName = Str::slug(Auth::user()->name, '_');
            $timestamp = time();

            $file = $request->file('bukti_pembayaran');
            $fileName = "PAYMENT_{$userName}_{$timestamp}." . $file->getClientOriginalExtension();

            // Hapus file lama jika ada
            if ($submission->bukti_pembayaran_path && Storage::disk('public')->exists($submission->bukti_pembayaran_path)) {
                Storage::disk('public')->delete($submission->bukti_pembayaran_path);
            }

            // Simpan file baru
            $filePath = $file->storeAs("apc/payments/{$userId}", $fileName, 'public');

            // 4. Update status dan path file di database
            $submission->update([
                'status' => 'verifikasi pembayaran',
                'bukti_pembayaran_path' => $filePath,
            ]);

            // 5. Tambahkan log status
            $submission->addStatusLog('verifikasi pembayaran', 'Dosen telah mengunggah bukti pembayaran.');

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.apc.manajemen')->with('success', 'Bukti pembayaran berhasil diunggah. Proposal sedang dalam tahap verifikasi oleh admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat mengunggah file: ' . $e->getMessage());
        }
    }

    private function authorizeAction(ApcSubmission $submission)
    {
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $session = $submission->session;
        if ($session->computed_status !== 'Buka') {
            return redirect()->route('subdirektorat-inovasi.dosen.apc.manajemen')->with('error', 'Tenggat waktu untuk sesi ini telah berakhir. Proposal tidak dapat diubah atau dihapus.')->send();
        }
    }
}

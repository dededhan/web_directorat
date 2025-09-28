<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
use App\Models\ComdevSubChapter;
use App\Models\ComdevSubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator; 
use App\Enums\ComdevStatusEnum;

class ComdevSubmissionFileController extends Controller
{
    /**
     * Menyimpan file yang diunggah atau diperbarui oleh dosen.
     */
    public function store(Request $request, ComdevSubmission $submission, ComdevSubChapter $subChapter)
    {
        // 1. Validasi dinamis berdasarkan tipe input
        $rules = [
            'type' => 'required|in:file,link',
        ];

        if ($request->input('type') === 'file') {
            $rules['file_dokumen'] = 'required|file|mimes:pdf|max:5120';
        } else {
            $rules['url'] = 'required|url|max:2048';
        }
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        // Cek otorisasi
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Cari data lama jika ada
        $existingRecord = ComdevSubmissionFile::where('comdev_submission_id', $submission->id)
            ->where('comdev_sub_chapter_id', $subChapter->id)
            ->first();

        $dataToUpdate = [
            'type' => $validated['type'],
        ];

        // 2. Logika kondisional untuk file atau link
        if ($validated['type'] === 'file') {
            // Jika ada file lama, hapus dari storage
            if ($existingRecord && $existingRecord->type === 'file' && Storage::disk('public')->exists($existingRecord->file_path)) {
                Storage::disk('public')->delete($existingRecord->file_path);
            }
            
            $file = $request->file('file_dokumen');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('comdev_files/' . $submission->id . '/' . $subChapter->id, $originalName, 'public');

            $dataToUpdate['file_path'] = $path;
            $dataToUpdate['original_filename'] = $originalName;
            $dataToUpdate['url'] = null; // Kosongkan URL

        } else { // Jika tipenya 'link'
            // Jika data lama adalah file, hapus file fisiknya
            if ($existingRecord && $existingRecord->type === 'file' && Storage::disk('public')->exists($existingRecord->file_path)) {
                Storage::disk('public')->delete($existingRecord->file_path);
            }

            $dataToUpdate['url'] = $validated['url'];
            $dataToUpdate['file_path'] = null; // Kosongkan path file
            $dataToUpdate['original_filename'] = null; // Kosongkan nama file
        }

        // 3. Gunakan updateOrCreate
        ComdevSubmissionFile::updateOrCreate(
            [
                'comdev_submission_id' => $submission->id,
                'comdev_sub_chapter_id' => $subChapter->id,
                'user_id' => Auth::id(),
            ],
            $dataToUpdate
        );
        
        // ... (Logika status Anda setelah ini tetap sama, tidak perlu diubah) ...
        $activeModuleStatus = $submission->activeModuleStatus;
        if ($activeModuleStatus) {
            $activeModule = $activeModuleStatus->module;
            $requiredSubChaptersCount = $activeModule->subChapters()->count();
            $uploadedFilesCount = ComdevSubmissionFile::where('comdev_submission_id', $submission->id)
                ->whereIn('comdev_sub_chapter_id', $activeModule->subChapters()->pluck('id'))
                ->count();

            if ($requiredSubChaptersCount > 0 && $requiredSubChaptersCount === $uploadedFilesCount) {
                // Ubah status jadi MENUNGGU_DIREVIEW jika semua sub-bab di modul aktif sudah terisi
                $activeModuleStatus->update(['status' => ComdevStatusEnum::MENUNGGU_DIREVIEW->value]);
            } else {
                 // Jika belum lengkap, pastikan statusnya kembali ke DIAJUKAN (atau status proses lainnya)
                 $activeModuleStatus->update(['status' => ComdevStatusEnum::DIAJUKAN->value]);
            }
        }

        return back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Mengunduh file yang sudah diunggah.
     */
    public function download(ComdevSubmissionFile $file)
    {
        // Cek otorisasi, pastikan file ini milik user yang login
        if ($file->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Cek apakah file ada di storage
        if (!Storage::disk('public')->exists($file->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($file->file_path, $file->original_filename);
    }

    /**
     * Menghapus file dan datanya.
     */
  public function destroy(ComdevSubmissionFile $file)
{
    // Cek otorisasi, pastikan file ini milik user yang login
    if ($file->user_id !== Auth::id()) {
        abort(403, 'AKSES DITOLAK');
    }

    // Hapus file dari storage HANYA JIKA file_path ADA dan file-nya EKSIS
    // Ini adalah perbaikan untuk mencegah error TypeError
    if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
        Storage::disk('public')->delete($file->file_path);
    }

    // Hapus data dari database
    $file->delete();

    // Menggunakan pesan yang lebih umum
    return back()->with('success', 'Data berhasil dihapus.');
}

    /**
     * Mengunduh template (contoh).
     */
    public function downloadTemplate($templateName)
    {
        $path = 'templates/' . $templateName . '.pdf'; // Asumsi template ada di public/storage/templates/

        if (!Storage::disk('public')->exists($path)) {
            return back()->with('error', 'File template tidak ditemukan.');
        }

        return Storage::disk('public')->download($path);
    }
}

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
        
         $rules = [
        'type' => 'required|in:file,link',
        'judul_luaran' => 'required|string|max:255',
        'status_luaran' => 'required|string|max:100', // Sesuaikan max length jika perlu
    ];


        if ($request->input('type') === 'file') {
        // Jika file sudah ada, validasi tidak wajib. Jika belum ada, wajib.
        $existingFile = ComdevSubmissionFile::where([
            'comdev_submission_id' => $submission->id,
            'comdev_sub_chapter_id' => $subChapter->id,
        ])->first();
        
        $rules['file_dokumen'] = ($existingFile && $existingFile->file_path) ? 'nullable' : 'required';
        $rules['file_dokumen'] .= '|file|mimes:pdf|max:5120';
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
        'judul_luaran' => $validated['judul_luaran'],
        'status_luaran' => $validated['status_luaran'],
    ];


        // 2. Logika kondisional untuk file atau link
       if ($validated['type'] === 'file') {
        // Hanya proses upload jika file baru diunggah
        if ($request->hasFile('file_dokumen')) {
            // Jika ada file lama, hapus dari storage
            if ($existingRecord && $existingRecord->type === 'file' && Storage::disk('public')->exists($existingRecord->file_path)) {
                Storage::disk('public')->delete($existingRecord->file_path);
            }
            
            $file = $request->file('file_dokumen');
            $originalName = $file->getClientOriginalName();
            $path = $file->storeAs('comdev_files/' . $submission->id . '/' . $subChapter->id, $originalName, 'public');

            $dataToUpdate['file_path'] = $path;
            $dataToUpdate['original_filename'] = $originalName;
        }
        $dataToUpdate['url'] = null; // Kosongkan URL

    } else { // Jika tipenya 'link'
        if ($existingRecord && $existingRecord->type === 'file' && Storage::disk('public')->exists($existingRecord->file_path)) {
            Storage::disk('public')->delete($existingRecord->file_path);
        }

        $dataToUpdate['url'] = $validated['url'];
        $dataToUpdate['file_path'] = null;
        $dataToUpdate['original_filename'] = null;
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
        
        // Update status proposal berdasarkan kelengkapan sub-bab wajib
        $activeModuleStatus = $submission->activeModuleStatus;
        if ($activeModuleStatus) {
            $activeModule = $activeModuleStatus->module;
            
            // Hitung hanya sub-bab yang wajib
            $requiredSubChaptersCount = $activeModule->subChapters()->where('is_wajib', true)->count();
            $requiredSubChapterIds = $activeModule->subChapters()->where('is_wajib', true)->pluck('id');
            
            $uploadedFilesCount = ComdevSubmissionFile::where('comdev_submission_id', $submission->id)
                ->whereIn('comdev_sub_chapter_id', $requiredSubChapterIds)
                ->count();

            if ($requiredSubChaptersCount > 0 && $requiredSubChaptersCount === $uploadedFilesCount) {
                // Ubah status jadi MENUNGGU_DIREVIEW jika semua sub-bab wajib di modul aktif sudah terisi
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

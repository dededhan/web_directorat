<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
use App\Models\ComdevSubChapter;
use App\Models\ComdevSubmissionFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComdevSubmissionFileController extends Controller
{
    /**
     * Menyimpan file yang diunggah atau diperbarui oleh dosen.
     */
    public function store(Request $request, ComdevSubmission $submission, ComdevSubChapter $subChapter)
    {
        // Validasi: file wajib ada, harus PDF, maks 5MB (5120 KB)
        $request->validate([
            'file_dokumen' => 'required|file|mimes:pdf|max:5120',
        ]);

        // Cek otorisasi, pastikan proposal ini milik user yang login
        if ($submission->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $file = $request->file('file_dokumen');
        $originalName = $file->getClientOriginalName();
        
        // Buat path penyimpanan yang unik: comdev_files/{id_submission}/{id_sub_chapter}/nama_file.pdf
        $path = $file->storeAs(
            'comdev_files/' . $submission->id . '/' . $subChapter->id,
            $originalName,
            'public'
        );

        // Cari file lama jika ada (untuk mode edit)
        $existingFile = ComdevSubmissionFile::where('comdev_submission_id', $submission->id)
            ->where('comdev_sub_chapter_id', $subChapter->id)
            ->where('user_id', Auth::id())
            ->first();

        // Hapus file lama dari storage jika ada
        if ($existingFile && Storage::disk('public')->exists($existingFile->file_path)) {
            Storage::disk('public')->delete($existingFile->file_path);
        }

        // Gunakan updateOrCreate untuk membuat data baru atau memperbarui yang lama
        ComdevSubmissionFile::updateOrCreate(
            [
                'comdev_submission_id' => $submission->id,
                'comdev_sub_chapter_id' => $subChapter->id,
                'user_id' => Auth::id(),
            ],
            [
                'file_path' => $path,
                'original_filename' => $originalName,
            ]
        );

        return back()->with('success', 'Dokumen berhasil diunggah.');
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

        // Hapus file dari storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }
        
        // Hapus data dari database
        $file->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
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

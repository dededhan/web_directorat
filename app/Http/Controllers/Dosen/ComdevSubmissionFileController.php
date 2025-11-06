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



       if ($validated['type'] === 'file') {
        if ($request->hasFile('file_dokumen')) {
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

    } else {
        if ($existingRecord && $existingRecord->type === 'file' && Storage::disk('public')->exists($existingRecord->file_path)) {
            Storage::disk('public')->delete($existingRecord->file_path);
        }

        $dataToUpdate['url'] = $validated['url'];
        $dataToUpdate['file_path'] = null;
        $dataToUpdate['original_filename'] = null;
    }



        ComdevSubmissionFile::updateOrCreate(
            [
                'comdev_submission_id' => $submission->id,
                'comdev_sub_chapter_id' => $subChapter->id,
                'user_id' => Auth::id(),
            ],
            $dataToUpdate
        );
        
        $activeModuleStatus = $submission->moduleStatuses()
            ->whereIn('status', ['proses', 'diajukan', 'menunggu_direview'])
            ->join('comdev_modules', 'comdev_submission_module_statuses.comdev_module_id', '=', 'comdev_modules.id')
            ->orderBy('comdev_modules.urutan', 'asc')
            ->select('comdev_submission_module_statuses.*')
            ->first();
        
        file_put_contents(storage_path('logs/file_upload_debug.txt'), 
            date('Y-m-d H:i:s') . " - File uploaded for submission {$submission->id}\n", 
            FILE_APPEND);
        
        if ($activeModuleStatus) {
            $activeModule = $activeModuleStatus->module;
            

            $requiredSubChaptersCount = $activeModule->subChapters()->where('is_wajib', true)->count();
            $requiredSubChapterIds = $activeModule->subChapters()->where('is_wajib', true)->pluck('id');
            
            $uploadedFilesCount = ComdevSubmissionFile::where('comdev_submission_id', $submission->id)
                ->whereIn('comdev_sub_chapter_id', $requiredSubChapterIds)
                ->count();

            // Debug log ke file
            file_put_contents(storage_path('logs/file_upload_debug.txt'), 
                "Module: {$activeModule->nama_modul}\n" .
                "Module Status: {$activeModuleStatus->status}\n" .
                "Required sub-chapters (wajib): {$requiredSubChaptersCount}\n" .
                "Required IDs: " . json_encode($requiredSubChapterIds->toArray()) . "\n" .
                "Uploaded files count: {$uploadedFilesCount}\n" .
                "Submission status: {$submission->status->value}\n", 
                FILE_APPEND);

            if ($requiredSubChaptersCount > 0 && $requiredSubChaptersCount === $uploadedFilesCount) {
                $activeModuleStatus->update(['status' => 'menunggu_direview']);
                $submission->update(['status' => ComdevStatusEnum::MENUNGGU_DIREVIEW]);
                file_put_contents(storage_path('logs/file_upload_debug.txt'), 
                    "✅ STATUS CHANGED TO MENUNGGU_DIREVIEW\n\n", 
                    FILE_APPEND);
            } else {
                 // Jika belum lengkap, pastikan statusnya sesuai dengan tahap
                 if ($activeModuleStatus->status == 'proses') {
                     $activeModuleStatus->update(['status' => 'proses']);
                     $submission->update(['status' => ComdevStatusEnum::PROSES_TAHAP_SELANJUTNYA]);
                 } else {
                     $activeModuleStatus->update(['status' => 'diajukan']);
                     $submission->update(['status' => ComdevStatusEnum::DIAJUKAN]);
                 }
                 file_put_contents(storage_path('logs/file_upload_debug.txt'), 
                    "⏳ Status remains - not all required files uploaded yet\n\n", 
                    FILE_APPEND);
            }
        } else {
            file_put_contents(storage_path('logs/file_upload_debug.txt'), 
                "❌ No active module status found!\n\n", 
                FILE_APPEND);
        }

        return back()->with('success', 'Data berhasil disimpan.');
    }

    /**
     * Preview file (view in browser).
     */
    public function preview(ComdevSubmissionFile $file)
    {
        $user = Auth::user();
        
        // Authorization check
        $isOwner = $file->user_id === $user->id;
        $isAdmin = in_array($user->role, ['reviewer_equity', 'admin_equity', 'sub_admin_equity']);
        $isAssignedReviewer = $file->submission->reviewers()->where('users.id', $user->id)->exists();
        
        $canView = $isOwner || $isAdmin || $isAssignedReviewer;
        
        if (!$canView) {
            abort(403, 'Anda tidak memiliki izin untuk melihat file ini.');
        }

        // Jika tipe adalah link, redirect ke URL
        if ($file->type === 'link' && $file->url) {
            return redirect($file->url);
        }

        // Jika tipe adalah file, cek apakah file ada di storage
        if ($file->type === 'file' && $file->file_path) {
            if (!Storage::disk('public')->exists($file->file_path)) {
                return back()->with('error', 'File tidak ditemukan di server.');
            }

            $filePath = Storage::disk('public')->path($file->file_path);
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $file->original_filename . '"'
            ]);
        }

        return back()->with('error', 'File tidak valid atau tidak ditemukan.');
    }

    /**
     * Mengunduh file yang sudah diunggah.
     */
    public function download(ComdevSubmissionFile $file)
    {
        $user = Auth::user();
        
        // Authorization check
        $isOwner = $file->user_id === $user->id;
        $isAdmin = in_array($user->role, ['reviewer_equity', 'admin_equity', 'sub_admin_equity']);
        $isAssignedReviewer = $file->submission->reviewers()->where('users.id', $user->id)->exists();
        
        $canDownload = $isOwner || $isAdmin || $isAssignedReviewer;
        
        if (!$canDownload) {
            abort(403, 'Anda tidak memiliki izin untuk mengunduh file ini.');
        }

        // Jika tipe adalah link, tidak bisa diunduh
        if ($file->type === 'link') {
            return back()->with('error', 'Link tidak dapat diunduh. Silakan gunakan tombol "Buka Link".');
        }

        // Cek apakah file ada di storage
        if (!$file->file_path || !Storage::disk('public')->exists($file->file_path)) {
            return back()->with('error', 'File tidak ditemukan di server.');
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

    $submission = $file->submission;

    // Hapus file dari storage HANYA JIKA file_path ADA dan file-nya EKSIS
    if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
        Storage::disk('public')->delete($file->file_path);
    }

    // Hapus data dari database
    $file->delete();

    // Cek ulang status setelah delete - apakah masih lengkap atau tidak
    $activeModuleStatus = $submission->moduleStatuses()
        ->whereIn('status', ['proses', 'diajukan', 'menunggu_direview'])
        ->join('comdev_modules', 'comdev_submission_module_statuses.comdev_module_id', '=', 'comdev_modules.id')
        ->orderBy('comdev_modules.urutan', 'asc')
        ->select('comdev_submission_module_statuses.*')
        ->first();

    if ($activeModuleStatus) {
        $activeModule = $activeModuleStatus->module;
        $requiredSubChaptersCount = $activeModule->subChapters()->where('is_wajib', true)->count();
        $requiredSubChapterIds = $activeModule->subChapters()->where('is_wajib', true)->pluck('id');
        
        $uploadedFilesCount = ComdevSubmissionFile::where('comdev_submission_id', $submission->id)
            ->whereIn('comdev_sub_chapter_id', $requiredSubChapterIds)
            ->count();

        // Jika tidak lengkap lagi, kembalikan status ke proses/diajukan
        if ($uploadedFilesCount < $requiredSubChaptersCount) {
            if ($activeModuleStatus->status == 'menunggu_direview') {
                $activeModuleStatus->update(['status' => 'proses']);
                $submission->update(['status' => ComdevStatusEnum::PROSES_TAHAP_SELANJUTNYA]);
            }
        }
    }

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

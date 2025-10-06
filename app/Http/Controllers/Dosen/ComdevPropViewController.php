<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
use App\Models\ComdevSubmissionFile;
use App\Models\ComdevReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComdevPropViewController extends Controller
{
    /**
     * Menampilkan halaman portofolio proposal milik dosen yang sedang login.
     * Dapat menerima filter berdasarkan sesi proposal.
     */
    public function index(Request $request)
    {
        // Memulai query untuk mengambil submission milik user yang login
        $query = ComdevSubmission::with('sesi') // Eager loading agar efisien
            ->where('user_id', Auth::id())
            ->latest(); // Urutkan dari yang terbaru

        // PERUBAHAN 1: Menambahkan filter berdasarkan sesi_id dari URL
        // Jika ada parameter 'sesi_id' di URL, tambahkan kondisi where ke query
        if ($request->has('sesi_id') && $request->sesi_id != '') {
            $query->where('comdev_proposal_id', $request->sesi_id);
        }

        // Eksekusi query dengan pagination
        $submissions = $query->paginate(10);

        // PERUBAHAN 2: Mengirim data ke view yang benar dan menambahkan data filter
        // View yang benar adalah 'manajement' bukan 'index'
        return view('subdirektorat-inovasi.dosen.equity.manajement', [
            'submissions' => $submissions,
            'filtered_sesi' => $request->sesi_id // Kirim ID sesi yang sedang difilter
        ]);
    }
    public function showTahapan(ComdevSubmission $submission)
    {
        // Pastikan dosen hanya bisa melihat proposal miliknya
        abort_if($submission->user_id !== Auth::id(), 403, 'Akses ditolak.');
        
        // Ambil semua template modul dari sesi, diurutkan
        $allModules = $submission->sesi->modules()->with('subChapters')->orderBy('urutan')->get();
        
        // Ambil status-status modul yang sudah ada untuk proposal ini
        $statuses = $submission->moduleStatuses->keyBy('comdev_module_id');
        
        $unlockedModules = collect(); // Koleksi untuk menyimpan modul yang "terbuka"
        $previousModulePassed = true; // Anggap modul "sebelum" yang pertama sudah lolos

        foreach ($allModules as $module) {
            // Jika modul sebelumnya tidak lolos, hentikan perulangan.
            if (!$previousModulePassed) {
                break;
            }

            // Jika modul ini adalah yang pertama, atau modul sebelumnya lolos, maka modul ini "terbuka"
            $status = $statuses->get($module->id);

            // Jika status untuk modul ini belum ada di database, buat status default 'proses'
            if (!$status) {
                $status = $submission->moduleStatuses()->create([
                    'comdev_module_id' => $module->id,
                    'status' => 'proses', // Status awal untuk modul yang baru terbuka
                ]);
            }
            
            // Tambahkan detail status ke objek modul untuk digunakan di view
            $module->status_details = $status;
            
            // Masukkan modul yang sudah terbuka ke dalam koleksi
            $unlockedModules->push($module);
            
            // Siapkan pengecekan untuk iterasi berikutnya
            $previousModulePassed = ($status->status === 'lolos');
        }

        // Kirim data ke view
        return view('subdirektorat-inovasi.dosen.equity.tahapan-proposal', [
            'submission' => $submission->load('reviews.reviewer', 'reviews.subChapter'),
            'modules' => $unlockedModules, // Kirim HANYA modul yang sudah terbuka
            'moduleStatuses' => $statuses 
        ]);
    }
}

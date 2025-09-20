<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
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
}

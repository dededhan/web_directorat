<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComdevProposal; // Model untuk sesi proposal
use App\Models\ComdevSubmission; // Model untuk data proposal yang diusulkan dosen
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan data user yang login
use Carbon\Carbon;

class ComdevViewSesiController extends Controller
{
    /**
     * Menampilkan daftar semua sesi proposal yang bisa diusulkan.
     */
    public function index()
    {
        // Mengambil semua sesi proposal yang tersedia
        $sesiTersedia = ComdevProposal::latest()->get();

        // Mengambil semua proposal (submission) yang dimiliki oleh user yang sedang login,
        // lalu dikelompokkan berdasarkan ID sesi proposalnya.
        // Ini penting agar kita bisa menampilkan status untuk setiap sesi.
        $userSubmissions = ComdevSubmission::where('user_id', Auth::id())
            ->get()
            ->groupBy('comdev_proposal_id');

        // Mengirim data sesi dan data proposal user ke view.
        return view('subdirektorat-inovasi.dosen.equity.usulkan-proposal', [
            'sesiTersedia' => $sesiTersedia,
            'userSubmissions' => $userSubmissions // Data baru yang dikirim ke view
        ]);
    }

    // Anda bisa menambahkan method lain di sini nanti jika diperlukan
    // untuk controller ini, misalnya untuk fitur search atau filter.
}
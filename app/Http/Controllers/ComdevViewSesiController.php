<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComdevProposal; // Model yang sama dari admin
use Carbon\Carbon;

class ComdevViewSesiController extends Controller
{
    /**
     * Menampilkan daftar semua sesi proposal yang bisa diusulkan.
     */
    public function index()
    {
        // Logika ini tetap sama: mengambil data dari model ComdevProposal.
        // Di masa depan, Anda bisa menambahkan model lain di sini.
        $sesiTersedia = ComdevProposal::latest()->get();

        // Mengirim data ke view yang sama.
        return view('subdirektorat-inovasi.dosen.equity.usulkan-proposal', [
            'sesiTersedia' => $sesiTersedia
        ]);
    }

    // Anda bisa menambahkan method lain di sini nanti jika diperlukan
    // untuk controller ini, misalnya untuk fitur search atau filter.
}

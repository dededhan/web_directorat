<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncentiveReviewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Data dummy untuk ditampilkan di tabel
        $dummyData = collect([
            (object)['id' => 1, 'nama_reviewer' => 'Dr. Budi Santoso', 'judul_artikel' => 'Analisis Sentimen pada Media Sosial', 'status' => 'Disetujui', 'tanggal_pengajuan' => '2023-10-26'],
            (object)['id' => 2, 'nama_reviewer' => 'Prof. Dr. Citra Lestari', 'judul_artikel' => 'Penerapan Machine Learning untuk Deteksi Penyakit', 'status' => 'Menunggu', 'tanggal_pengajuan' => '2023-10-25'],
        ]);

        return view('admin_equity.incentivereviewer.index', ['submissions' => $dummyData]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_equity.incentivereviewer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Logika untuk menyimpan data baru
        // redirect()->route('admin_equity.incentivereviewer.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Ambil data dummy berdasarkan ID untuk halaman show
        $dummyDetail = (object)['id' => $id, 'nama_reviewer' => 'Dr. Budi Santoso', 'judul_artikel' => 'Analisis Sentimen pada Media Sosial', 'status' => 'Disetujui', 'tanggal_pengajuan' => '2023-10-26', 'abstrak' => 'Ini adalah contoh abstrak dari artikel yang direview.'];
        return view('admin_equity.incentivereviewer.show', ['submission' => $dummyDetail]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Ambil data dummy berdasarkan ID untuk halaman edit
        $dummyEdit = (object)['id' => $id, 'nama_reviewer' => 'Dr. Budi Santoso', 'judul_artikel' => 'Analisis Sentimen pada Media Sosial', 'status' => 'Disetujui'];
        return view('admin_equity.incentivereviewer.edit', ['submission' => $dummyEdit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Logika untuk memperbarui data
        // return redirect()->route('admin_equity.incentivereviewer.index')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Logika untuk menghapus data
        // return redirect()->route('admin_equity.incentivereviewer.index')->with('success', 'Data berhasil dihapus!');
    }
}

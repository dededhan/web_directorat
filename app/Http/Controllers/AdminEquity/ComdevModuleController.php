<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\ComdevProposal;
use App\Models\ComdevModule;
use App\Models\ComdevSubChapter;
use Illuminate\Http\Request;

class ComdevModuleController extends Controller
{
    /**
     * Menampilkan halaman manajemen modul untuk sesi tertentu.
     */
    public function index(ComdevProposal $sesi)
    {
        // Menggunakan nama relasi yang sudah didefinisikan di model ComdevProposal
        $modules = $sesi->modules()->with('subChapters')->orderBy('urutan')->get();
        return view('admin_equity.comdev.modules.index', ['sesi' => $sesi, 'modules' => $modules]);
    }

    /**
     * Menyimpan modul baru.
     */
    public function storeModule(Request $request, ComdevProposal $sesi)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer',
        ]);

        $sesi->modules()->create($request->all());

        return back()->with('success', 'Modul baru berhasil ditambahkan.');
    }

    /**
     * Menghapus modul.
     */
    public function destroyModule(ComdevModule $module)
    {
        $module->delete();
        return back()->with('success', 'Modul berhasil dihapus.');
    }

    /**
     * Menyimpan sub-bab baru.
     */
    public function storeSubChapter(Request $request, ComdevModule $module)
    {
        $request->validate([
            'nama_sub_bab' => 'required|string|max:255',
            'deskripsi_instruksi' => 'nullable|string',
            'urutan' => 'required|integer',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
        ]);

        $module->subChapters()->create($request->all());

        return back()->with('success', 'Sub-bab baru berhasil ditambahkan.');
    }

    /**
     * Menghapus sub-bab.
     */
    public function destroySubChapter(ComdevSubChapter $subChapter)
    {
        $subChapter->delete();
        return back()->with('success', 'Sub-bab berhasil dihapus.');
    }
}


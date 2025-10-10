<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\SesiHibahModul;
use App\Models\ModulAkhir;
use App\Models\ModulSubChapter;
use Illuminate\Http\Request;

class ModulAkhirController extends Controller
{
    public function index(SesiHibahModul $sesi)
    {
        $moduls = ModulAkhir::where('sesi_hibah_modul_id', $sesi->id)
            ->withCount('subChapters')
            ->orderBy('urutan')
            ->get();
        
        return view('admin_equity.hibah_modul.moduls.index', compact('sesi', 'moduls'));
    }

    public function storeModul(Request $request, SesiHibahModul $sesi)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'urutan' => 'required|integer|min:1',
        ]);

        ModulAkhir::create([
            'sesi_hibah_modul_id' => $sesi->id,
            'judul_modul' => $request->judul_modul,
            'deskripsi' => $request->deskripsi,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'urutan' => $request->urutan,
        ]);

        return back()->with('success', 'Modul berhasil ditambahkan.');
    }

    public function updateModul(Request $request, SesiHibahModul $sesi, $modul)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'urutan' => 'required|integer|min:1',
        ]);

        $modulAkhir = ModulAkhir::findOrFail($modul);
        $modulAkhir->update($request->all());

        return back()->with('success', 'Modul berhasil diperbarui.');
    }

    public function destroyModul(SesiHibahModul $sesi, $modul)
    {
        $modulAkhir = ModulAkhir::findOrFail($modul);
        $modulAkhir->delete();
        
        return back()->with('success', 'Modul berhasil dihapus.');
    }

    public function storeSubChapter(Request $request, SesiHibahModul $sesi, $modul)
    {
        $request->validate([
            'judul_sub_chapter' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_input' => 'required|in:pdf,link,pdf_atau_link',
            'is_wajib' => 'required|boolean',
            'urutan' => 'required|integer|min:1',
        ]);

        ModulSubChapter::create([
            'modul_akhir_id' => $modul,
            'judul_sub_chapter' => $request->judul_sub_chapter,
            'deskripsi' => $request->deskripsi,
            'tipe_input' => $request->tipe_input,
            'is_wajib' => $request->is_wajib,
            'urutan' => $request->urutan,
        ]);

        return back()->with('success', 'Sub chapter berhasil ditambahkan.');
    }

    public function updateSubChapter(Request $request, SesiHibahModul $sesi, $subChapter)
    {
        $request->validate([
            'judul_sub_chapter' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_input' => 'required|in:pdf,link,pdf_atau_link',
            'is_wajib' => 'required|boolean',
            'urutan' => 'required|integer|min:1',
        ]);

        $subChapterModel = ModulSubChapter::findOrFail($subChapter);
        $subChapterModel->update($request->all());

        return back()->with('success', 'Sub chapter berhasil diperbarui.');
    }

    public function destroySubChapter(SesiHibahModul $sesi, $subChapter)
    {
        $subChapterModel = ModulSubChapter::findOrFail($subChapter);
        $subChapterModel->delete();
        
        return back()->with('success', 'Sub chapter berhasil dihapus.');
    }
}

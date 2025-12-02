<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\SesiStudentExchange;
use App\Models\StudentExchangeModul;
use App\Models\StudentExchangeSubChapter;
use Illuminate\Http\Request;

class StudentExchangeModulController extends Controller
{
    /**
     * Display a listing of modules for a specific session.
     */
    public function index(SesiStudentExchange $sesi)
    {
        $moduls = StudentExchangeModul::where('sesi_student_exchange_id', $sesi->id)
            ->withCount('subChapters')
            ->orderBy('urutan')
            ->get();
        
        return view('admin_equity.student-exchange.moduls.index', compact('sesi', 'moduls'));
    }

    /**
     * Store a newly created module in storage.
     */
    public function storeModul(Request $request, SesiStudentExchange $sesi)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'urutan' => 'required|integer|min:1',
        ]);

        StudentExchangeModul::create([
            'sesi_student_exchange_id' => $sesi->id,
            'judul_modul' => $request->judul_modul,
            'deskripsi' => $request->deskripsi,
            'periode_awal' => $request->periode_awal,
            'periode_akhir' => $request->periode_akhir,
            'urutan' => $request->urutan,
        ]);

        return back()->with('success', 'Modul berhasil ditambahkan.');
    }

    /**
     * Update the specified module in storage.
     */
    public function updateModul(Request $request, SesiStudentExchange $sesi, $modul)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'urutan' => 'required|integer|min:1',
        ]);

        $modulAkhir = StudentExchangeModul::findOrFail($modul);
        
        // Ensure module belongs to the session
        abort_if($modulAkhir->sesi_student_exchange_id !== $sesi->id, 404);
        
        $modulAkhir->update($request->all());

        return back()->with('success', 'Modul berhasil diperbarui.');
    }

    /**
     * Remove the specified module from storage.
     */
    public function destroyModul(SesiStudentExchange $sesi, $modul)
    {
        $modulAkhir = StudentExchangeModul::findOrFail($modul);
        
        // Ensure module belongs to the session
        abort_if($modulAkhir->sesi_student_exchange_id !== $sesi->id, 404);
        
        $modulAkhir->delete();
        
        return back()->with('success', 'Modul berhasil dihapus.');
    }

    /**
     * Store a newly created sub-chapter in storage.
     */
    public function storeSubChapter(Request $request, SesiStudentExchange $sesi, $modul)
    {
        $request->validate([
            'judul_sub_chapter' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_input' => 'required|in:pdf,link,pdf_atau_link',
            'is_wajib' => 'required|boolean',
            'urutan' => 'required|integer|min:1',
        ]);

        $modulAkhir = StudentExchangeModul::findOrFail($modul);
        
        // Ensure module belongs to the session
        abort_if($modulAkhir->sesi_student_exchange_id !== $sesi->id, 404);

        StudentExchangeSubChapter::create([
            'student_exchange_modul_id' => $modul,
            'judul_sub_chapter' => $request->judul_sub_chapter,
            'deskripsi' => $request->deskripsi,
            'tipe_input' => $request->tipe_input,
            'is_wajib' => $request->is_wajib,
            'urutan' => $request->urutan,
        ]);

        return back()->with('success', 'Sub chapter berhasil ditambahkan.');
    }

    /**
     * Update the specified sub-chapter in storage.
     */
    public function updateSubChapter(Request $request, SesiStudentExchange $sesi, $subChapter)
    {
        $request->validate([
            'judul_sub_chapter' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe_input' => 'required|in:pdf,link,pdf_atau_link',
            'is_wajib' => 'required|boolean',
            'urutan' => 'required|integer|min:1',
        ]);

        $subChapterModel = StudentExchangeSubChapter::findOrFail($subChapter);
        
        // Ensure sub-chapter's module belongs to the session
        $modul = $subChapterModel->modul;
        abort_if($modul->sesi_student_exchange_id !== $sesi->id, 404);
        
        $subChapterModel->update($request->all());

        return back()->with('success', 'Sub chapter berhasil diperbarui.');
    }

    /**
     * Remove the specified sub-chapter from storage.
     */
    public function destroySubChapter(SesiStudentExchange $sesi, $subChapter)
    {
        $subChapterModel = StudentExchangeSubChapter::findOrFail($subChapter);
        
        // Ensure sub-chapter's module belongs to the session
        $modul = $subChapterModel->modul;
        abort_if($modul->sesi_student_exchange_id !== $sesi->id, 404);
        
        $subChapterModel->delete();
        
        return back()->with('success', 'Sub chapter berhasil dihapus.');
    }

    /**
     * Reorder modules within a session.
     */
    public function reorderModuls(Request $request, SesiStudentExchange $sesi)
    {
        $request->validate([
            'moduls' => 'required|array',
            'moduls.*.id' => 'required|exists:student_exchange_modul,id',
            'moduls.*.urutan' => 'required|integer|min:1',
        ]);

        foreach ($request->moduls as $modulData) {
            $modul = StudentExchangeModul::findOrFail($modulData['id']);
            
            // Ensure module belongs to the session
            if ($modul->sesi_student_exchange_id === $sesi->id) {
                $modul->update(['urutan' => $modulData['urutan']]);
            }
        }

        return back()->with('success', 'Urutan modul berhasil diperbarui.');
    }

    /**
     * Reorder sub-chapters within a module.
     */
    public function reorderSubChapters(Request $request, SesiStudentExchange $sesi, $modul)
    {
        $request->validate([
            'subchapters' => 'required|array',
            'subchapters.*.id' => 'required|exists:student_exchange_sub_chapter,id',
            'subchapters.*.urutan' => 'required|integer|min:1',
        ]);

        $modulModel = StudentExchangeModul::findOrFail($modul);
        
        // Ensure module belongs to the session
        abort_if($modulModel->sesi_student_exchange_id !== $sesi->id, 404);

        foreach ($request->subchapters as $subChapterData) {
            $subChapter = StudentExchangeSubChapter::findOrFail($subChapterData['id']);
            
            // Ensure sub-chapter belongs to the module
            if ($subChapter->student_exchange_modul_id == $modul) {
                $subChapter->update(['urutan' => $subChapterData['urutan']]);
            }
        }

        return back()->with('success', 'Urutan sub chapter berhasil diperbarui.');
    }
}

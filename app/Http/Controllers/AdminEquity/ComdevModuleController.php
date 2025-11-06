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
     * [NEW] Creates a standard set of modules and sub-chapters from a predefined template.
     */
    public function storeTemplate(Request $request, ComdevProposal $sesi)
    {
        // Security check: Only allow template creation if no modules exist, to prevent duplication.
        if ($sesi->modules()->exists()) {
            return back()->with('error', 'Modul standar hanya dapat dibuat jika sesi belum memiliki modul.');
        }

        // Predefined template structure based on 'tahapan(modules format).blade.php'
        $template = [
            [
                'urutan' => 1, 'nama_modul' => 'Desk Evaluasi Proposal', 'deskripsi' => 'Tahap awal evaluasi proposal yang diajukan.',
                'sub_chapters' => [
                    ['urutan' => 1, 'nama_sub_bab' => 'Proposal Kegiatan'],
                    ['urutan' => 2, 'nama_sub_bab' => 'Surat Kesediaan Mitra Nasional'],
                    ['urutan' => 3, 'nama_sub_bab' => 'Surat Kesediaan Mitra Internasional'],
                    ['urutan' => 4, 'nama_sub_bab' => 'Surat Kesediaan Memenuhi Luaran Wajib'],
                ]
            ],
            [
                'urutan' => 2, 'nama_modul' => 'Perbaikan Proposal', 'deskripsi' => 'Tahap untuk melakukan perbaikan proposal berdasarkan hasil evaluasi.',
                'sub_chapters' => [
                    ['urutan' => 1, 'nama_sub_bab' => 'Proposal Perbaikan'],
                ]
            ],
            [
                'urutan' => 3, 'nama_modul' => 'Monitoring Evaluasi', 'deskripsi' => 'Tahap monitoring dan evaluasi kemajuan kegiatan.',
                'sub_chapters' => [
                    ['urutan' => 1, 'nama_sub_bab' => 'Laporan Kemajuan Kegiatan'],
                    ['urutan' => 2, 'nama_sub_bab' => 'SPTB Penelitian 70%'],
                    ['urutan' => 3, 'nama_sub_bab' => 'Daftar Peserta'],
                    ['urutan' => 4, 'nama_sub_bab' => ' Draft Luaran Media Massa'],
                   
                ]
            ],
            [
                'urutan' => 4, 'nama_modul' => 'Laporan Akhir', 'deskripsi' => 'Tahap pengumpulan laporan akhir dari seluruh kegiatan.',
                'sub_chapters' => [
                    ['urutan' => 1, 'nama_sub_bab' => 'Laporan Akhir Kegiatan'],
                    ['urutan' => 2, 'nama_sub_bab' => 'Laporan Keuangan 100%'],
                    ['urutan' => 3, 'nama_sub_bab' => 'SPTB Kegiatan 100%'],
                    ['urutan' => 4, 'nama_sub_bab' => 'Link Berita Kegiatan'],
                ]
            ],
            [
                'urutan' => 5, 'nama_modul' => 'Seminar Hasil/Penilaian Luaran', 'deskripsi' => 'Tahap akhir untuk presentasi hasil dan penilaian luaran.',
                'sub_chapters' => [] // No default sub-chapters for this module
            ],
        ];

        // Loop through the template and create database records
        foreach ($template as $moduleData) {
            $newModule = $sesi->modules()->create([
                'urutan' => $moduleData['urutan'],
                'nama_modul' => $moduleData['nama_modul'],
                'deskripsi' => $moduleData['deskripsi'],
            ]);

            if (!empty($moduleData['sub_chapters'])) {
                foreach ($moduleData['sub_chapters'] as $subChapterData) {
                    $newModule->subChapters()->create([
                        'urutan' => $subChapterData['urutan'],
                        'nama_sub_bab' => $subChapterData['nama_sub_bab'],
                    ]);
                }
            }
        }

        return back()->with('success', 'Modul standar berhasil dibuat.');
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
            'form_penilaian' => 'nullable|array',
            'form_penilaian.*.label' => 'required|string|max:255',
            'form_penilaian.*.type' => 'required|in:number,text,textarea',
            'form_penilaian.*.bobot' => 'nullable|numeric|min:0|max:100',
            'form_penilaian.*.keterangan' => 'nullable|string',
        ]);

        $sesi->modules()->create($request->all());

        return back()->with('success', 'Modul baru berhasil ditambahkan.');
    }

    /**
     * Mengupdate modul yang sudah ada.
     */
    public function updateModule(Request $request, ComdevModule $module)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer',
            'form_penilaian' => 'nullable|array',
            'form_penilaian.*.label' => 'required|string|max:255',
            'form_penilaian.*.type' => 'required|in:number,text,textarea',
            'form_penilaian.*.bobot' => 'nullable|numeric|min:0|max:100',
            'form_penilaian.*.keterangan' => 'nullable|string',
        ]);

        $module->update($request->all());

        return back()->with('success', 'Modul berhasil diperbarui.');
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
            'is_wajib' => 'nullable|boolean',
        ]);

        $module->subChapters()->create($request->all());

        return back()->with('success', 'Sub-bab baru berhasil ditambahkan.');
    }

        public function updateSubChapter(Request $request, ComdevSubChapter $subChapter)
    {
        $request->validate([
            'nama_sub_bab' => 'required|string|max:255',
            'deskripsi_instruksi' => 'nullable|string',
            'urutan' => 'required|integer',
            'periode_awal' => 'nullable|date',
            'periode_akhir' => 'nullable|date|after_or_equal:periode_awal',
            'is_wajib' => 'nullable|boolean',
        ]);

        $subChapter->update($request->all());

        return back()->with('success', 'Sub-bab berhasil diperbarui.');
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


<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ProposalModul;
use App\Models\ModulSubmissionFile;
use App\Models\ModulSubChapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModulAkhirDosenController extends Controller
{
    public function showLaporanAkhir(ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        abort_if(!in_array($proposal->status, ['diterima', 'menunggu_direview', 'sedang_direview', 'lolos', 'tidak_lolos']), 403, 'Laporan akhir belum tersedia.');
        
        $proposal->load([
            'sesi.moduls.subChapters',
            'files'
        ]);
        
        $moduls = $proposal->sesi->moduls;
        
        return view('subdirektorat-inovasi.dosen.hibah_modul.laporan_akhir', compact('proposal', 'moduls'));
    }

    public function uploadFile(Request $request, ProposalModul $proposal, ModulSubChapter $subChapter)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        
        $request->validate([
            'tipe_file' => 'required|in:pdf,link',
            'file_path' => 'required_if:tipe_file,pdf|file|mimes:pdf|max:10240',
            'link_url' => 'required_if:tipe_file,link|nullable|url',
            'keterangan' => 'nullable|string',
        ]);

        $existingFile = ModulSubmissionFile::where('proposal_modul_id', $proposal->id)
            ->where('modul_sub_chapter_id', $subChapter->id)
            ->first();

        if ($existingFile) {
            if ($existingFile->file_path) {
                Storage::disk('public')->delete($existingFile->file_path);
            }
            $existingFile->delete();
        }

        $data = [
            'proposal_modul_id' => $proposal->id,
            'modul_sub_chapter_id' => $subChapter->id,
            'tipe_file' => $request->tipe_file,
            'keterangan' => $request->keterangan,
        ];

        if ($request->tipe_file === 'pdf' && $request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('hibah_modul/laporan_akhir', 'public');
            $data['link_url'] = null;
        } else {
            $data['link_url'] = $request->link_url;
            $data['file_path'] = null;
        }

        ModulSubmissionFile::create($data);

        return back()->with('success', 'File berhasil diunggah.');
    }

    public function deleteFile(ModulSubmissionFile $file)
    {
        abort_if($file->proposal->user_id !== Auth::id(), 403);

        if ($file->file_path) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return back()->with('success', 'File berhasil dihapus.');
    }

    public function downloadFile(ModulSubmissionFile $file)
    {
        abort_if($file->proposal->user_id !== Auth::id(), 403);

        if (!$file->file_path || !Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::disk('public')->download($file->file_path);
    }
}

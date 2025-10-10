<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\SesiHibahModul;
use App\Models\ProposalModul;
use App\Models\AnggotaPenyusun;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProposalModulDosenController extends Controller
{
    public function listSesi()
    {
        $sessions = SesiHibahModul::where('status', 'dibuka')
            ->where('periode_akhir', '>=', now())
            ->orderBy('periode_awal', 'desc')
            ->get();
        
        return view('subdirektorat-inovasi.dosen.hibah_modul.list_sesi', compact('sessions'));
    }

    public function manageProposals()
    {
        $proposals = ProposalModul::where('user_id', Auth::id())
            ->with(['sesi', 'anggota', 'reviewer'])
            ->latest()
            ->paginate(10);
        
        return view('subdirektorat-inovasi.dosen.hibah_modul.manage_proposals', compact('proposals'));
    }

    public function createForm(SesiHibahModul $sesi)
    {
        return view('subdirektorat-inovasi.dosen.hibah_modul.create_proposal', compact('sesi'));
    }

    public function store(Request $request, SesiHibahModul $sesi)
    {
        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'ringkasan_modul' => 'required|string|max:300',
            'kata_kunci' => 'nullable|string',
            'sdgs' => 'nullable|string',
            'file_proposal' => 'required|file|mimes:pdf|max:10240',
            
            'anggota' => 'nullable|array',
            'anggota.*.nama_dosen' => 'required_with:anggota|string|max:255',
            'anggota.*.nip' => 'nullable|string|max:50',
            'anggota.*.fakultas' => 'nullable|string|max:255',
            'anggota.*.prodi' => 'nullable|string|max:255',
        ], [
            'ringkasan_modul.max' => 'Ringkasan modul maksimal 300 kata.',
            'file_proposal.required' => 'File proposal wajib diunggah.',
            'file_proposal.mimes' => 'File proposal harus berformat PDF.',
            'file_proposal.max' => 'Ukuran file proposal maksimal 10MB.',
        ]);

        DB::beginTransaction();
        try {
            $filePath = null;
            if ($request->hasFile('file_proposal')) {
                $filePath = $request->file('file_proposal')->store('hibah_modul/proposals', 'public');
            }

            // Parse kata_kunci and sdgs if they are JSON strings
            $kataKunci = null;
            if ($request->kata_kunci) {
                $decoded = json_decode($request->kata_kunci);
                $kataKunci = is_array($decoded) ? $decoded : null;
            }
            
            $sdgs = null;
            if ($request->sdgs) {
                $decoded = json_decode($request->sdgs);
                $sdgs = is_array($decoded) ? $decoded : null;
            }

            $proposal = ProposalModul::create([
                'sesi_hibah_modul_id' => $sesi->id,
                'user_id' => Auth::id(),
                'judul_modul' => $request->judul_modul,
                'ringkasan_modul' => $request->ringkasan_modul,
                'kata_kunci' => $kataKunci,
                'sdgs' => $sdgs,
                'file_proposal' => $filePath,
                'status' => 'draft',
            ]);

            if ($request->filled('anggota')) {
                foreach ($request->anggota as $index => $anggotaData) {
                    AnggotaPenyusun::create([
                        'proposal_modul_id' => $proposal->id,
                        'nama_dosen' => $anggotaData['nama_dosen'],
                        'nip' => $anggotaData['nip'] ?? null,
                        'fakultas' => $anggotaData['fakultas'] ?? null,
                        'prodi' => $anggotaData['prodi'] ?? null,
                        'urutan' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.hibah_modul.manage')
                ->with('success', 'Proposal berhasil dibuat dalam status draft.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        
        $proposal->load(['sesi', 'anggota', 'reviewer', 'files.subChapter', 'reviews.reviewer']);
        
        return view('subdirektorat-inovasi.dosen.hibah_modul.show_proposal', compact('proposal'));
    }

    public function edit(ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        abort_if(!in_array($proposal->status, ['draft', 'diajukan']), 403, 'Proposal tidak dapat diedit.');
        
        $proposal->load('anggota');
        
        return view('subdirektorat-inovasi.dosen.hibah_modul.edit_proposal', compact('proposal'));
    }

    public function update(Request $request, ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        abort_if(!in_array($proposal->status, ['draft', 'diajukan']), 403);

        $request->validate([
            'judul_modul' => 'required|string|max:255',
            'ringkasan_modul' => 'required|string|max:300',
            'kata_kunci' => 'nullable|string',
            'sdgs' => 'nullable|string',
            'file_proposal' => 'nullable|file|mimes:pdf|max:10240',
            
            'anggota' => 'nullable|array',
            'anggota.*.nama_dosen' => 'required_with:anggota|string|max:255',
            'anggota.*.nip' => 'nullable|string|max:50',
            'anggota.*.fakultas' => 'nullable|string|max:255',
            'anggota.*.prodi' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Parse kata_kunci and sdgs if they are JSON strings
            $kataKunci = null;
            if ($request->kata_kunci) {
                $decoded = json_decode($request->kata_kunci);
                $kataKunci = is_array($decoded) ? $decoded : null;
            }
            
            $sdgs = null;
            if ($request->sdgs) {
                $decoded = json_decode($request->sdgs);
                $sdgs = is_array($decoded) ? $decoded : null;
            }

            $data = [
                'judul_modul' => $request->judul_modul,
                'ringkasan_modul' => $request->ringkasan_modul,
                'kata_kunci' => $kataKunci,
                'sdgs' => $sdgs,
            ];

            if ($request->hasFile('file_proposal')) {
                if ($proposal->file_proposal) {
                    Storage::disk('public')->delete($proposal->file_proposal);
                }
                
                $data['file_proposal'] = $request->file('file_proposal')->store('hibah_modul/proposals', 'public');
            }

            $proposal->update($data);

            $proposal->anggota()->delete();

            if ($request->filled('anggota')) {
                foreach ($request->anggota as $index => $anggotaData) {
                    AnggotaPenyusun::create([
                        'proposal_modul_id' => $proposal->id,
                        'nama_dosen' => $anggotaData['nama_dosen'],
                        'nip' => $anggotaData['nip'] ?? null,
                        'fakultas' => $anggotaData['fakultas'] ?? null,
                        'prodi' => $anggotaData['prodi'] ?? null,
                        'urutan' => $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('subdirektorat-inovasi.dosen.hibah_modul.manage')
                ->with('success', 'Proposal berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function confirm(ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        abort_if($proposal->status !== 'draft', 403, 'Proposal sudah diajukan.');

        $proposal->update(['status' => 'diajukan']);

        return back()->with('success', 'Proposal berhasil diajukan dan menunggu verifikasi admin.');
    }

    public function confirmVerifikasi(ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        abort_if($proposal->status !== 'diajukan', 403, 'Status proposal tidak valid.');

        $proposal->update(['status' => 'menunggu_verifikasi']);

        return back()->with('success', 'Proposal telah dikonfirmasi dan menunggu verifikasi admin.');
    }

    public function destroy(ProposalModul $proposal)
    {
        abort_if($proposal->user_id !== Auth::id(), 403);
        abort_if(!in_array($proposal->status, ['draft', 'diajukan']), 403, 'Proposal tidak dapat dihapus.');

        if ($proposal->file_proposal) {
            Storage::disk('public')->delete($proposal->file_proposal);
        }

        $proposal->delete();

        return redirect()->route('subdirektorat-inovasi.dosen.hibah_modul.manage')
            ->with('success', 'Proposal berhasil dihapus.');
    }
}

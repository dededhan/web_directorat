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
use Illuminate\Support\Facades\Log;

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
            'kata_kunci' => 'nullable|json', // Diubah menjadi json
            'sdgs' => 'nullable|json',       // Diubah menjadi json
            'file_proposal' => 'required|file|mimes:pdf|max:10240',
            
            'anggota' => 'nullable|array',
            'anggota.*.nama_dosen' => 'required_with:anggota|string|max:255',
            'anggota.*.nip' => 'nullable|string|max:50',
            'anggota.*.fakultas' => 'nullable|string|max:255', // Sudah ada, tidak perlu diubah
            'anggota.*.prodi' => 'nullable|string|max:255',    // Sudah ada, tidak perlu diubah
        ], [
            'ringkasan_modul.max' => 'Ringkasan modul maksimal 300 kata.',
            'file_proposal.required' => 'File proposal wajib diunggah.',
            'file_proposal.mimes' => 'File proposal harus berformat PDF.',
            'file_proposal.max' => 'Ukuran file proposal maksimal 10MB.',
            'kata_kunci.json' => 'Format kata kunci tidak valid.',
            'sdgs.json' => 'Format SDGs tidak valid.',
        ]);

        DB::beginTransaction();
        try {
            $filePath = $request->file('file_proposal')->store('hibah_modul/proposals', 'public');

            // --- FUNGSI BARU UNTUK DECODE INPUT DARI TAGIFY/JSON ---
            $decodeJsonInput = function ($jsonString) {
                if (empty($jsonString)) return null;
                $data = json_decode($jsonString, true);
                // Cek jika hasil decode adalah array dan punya key 'value' (format Tagify)
                if (is_array($data) && !empty($data) && isset($data[0]['value'])) {
                    return array_column($data, 'value');
                }
                // Jika sudah array biasa (dari dropdown SDG atau old input), langsung kembalikan
                return is_array($data) ? $data : null;
            };

            $proposal = ProposalModul::create([
                'sesi_hibah_modul_id' => $sesi->id,
                'user_id' => Auth::id(),
                'judul_modul' => $request->judul_modul,
                'ringkasan_modul' => $request->ringkasan_modul,
                'kata_kunci' => $decodeJsonInput($request->kata_kunci), // Menggunakan fungsi decode
                'sdgs' => $decodeJsonInput($request->sdgs),             // Menggunakan fungsi decode
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
            Log::error('Error storing proposal modul: ' . $e->getMessage()); // Tambahkan logging
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
            'kata_kunci' => 'nullable|json', // Diubah menjadi json
            'sdgs' => 'nullable|json',       // Diubah menjadi json
            'file_proposal' => 'nullable|file|mimes:pdf|max:10240',
            
            'anggota' => 'nullable|array',
            'anggota.*.nama_dosen' => 'required_with:anggota|string|max:255',
            'anggota.*.nip' => 'nullable|string|max:50',
            'anggota.*.fakultas' => 'nullable|string|max:255',
            'anggota.*.prodi' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // --- FUNGSI BARU UNTUK DECODE INPUT DARI TAGIFY/JSON ---
            $decodeJsonInput = function ($jsonString) {
                if (empty($jsonString)) return null;
                $data = json_decode($jsonString, true);
                if (is_array($data) && !empty($data) && isset($data[0]['value'])) {
                    return array_column($data, 'value');
                }
                return is_array($data) ? $data : null;
            };

            $data = [
                'judul_modul' => $request->judul_modul,
                'ringkasan_modul' => $request->ringkasan_modul,
                'kata_kunci' => $decodeJsonInput($request->kata_kunci), // Menggunakan fungsi decode
                'sdgs' => $decodeJsonInput($request->sdgs),             // Menggunakan fungsi decode
            ];

            if ($request->hasFile('file_proposal')) {
                if ($proposal->file_proposal) Storage::disk('public')->delete($proposal->file_proposal);
                $data['file_proposal'] = $request->file('file_proposal')->store('hibah_modul/proposals', 'public');
            }

            $proposal->update($data);
            $proposal->anggota()->delete(); // Hapus anggota lama sebelum menambahkan yang baru

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
            Log::error('Error updating proposal modul: ' . $e->getMessage()); // Tambahkan logging
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

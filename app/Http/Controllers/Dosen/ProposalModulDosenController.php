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
            'kata_kunci' => 'nullable|json',
            'sdgs_fokus' => 'nullable|json',
            'sdgs_pendukung' => 'nullable|json',
            'file_proposal' => 'required|file|mimes:pdf|max:10240',
            
            // New fields
            'tahun_usulan' => 'required|string|max:4',
            'tahun_pelaksanaan' => 'required|string|max:4',
            'tempat_pelaksanaan' => 'required|string|max:255',
            'anggaran_usulan' => 'required|string',
            'platform_digital' => 'required|string|max:255',
            'mitra' => 'nullable|string|max:255',
            'modul_interdisiplin' => 'required|in:Ada,Draft',
            'publikasi_media_massa' => 'required|in:Ada,Draft',
            'nama_media_massa' => 'required_if:publikasi_media_massa,Ada,Draft|nullable|string|max:255',
            'hki' => 'required|in:Ada,Draft',
            'jenis_hki_dan_judul' => 'required_if:hki,Ada,Draft|nullable|string',
            
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
            'kata_kunci.json' => 'Format kata kunci tidak valid.',
            'sdgs_fokus.json' => 'Format SDGs Fokus tidak valid.',
            'sdgs_pendukung.json' => 'Format SDGs Pendukung tidak valid.',
            'tahun_usulan.required' => 'Tahun usulan wajib diisi.',
            'tahun_pelaksanaan.required' => 'Tahun pelaksanaan wajib diisi.',
            'tempat_pelaksanaan.required' => 'Tempat pelaksanaan wajib diisi.',
            'anggaran_usulan.required' => 'Anggaran usulan wajib diisi.',
            'platform_digital.required' => 'Platform digital wajib diisi.',
            'nama_media_massa.required_if' => 'Nama media massa wajib diisi jika publikasi media massa ada.',
            'jenis_hki_dan_judul.required_if' => 'Jenis HKI dan judul wajib diisi jika HKI ada.',
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

            // Clean anggaran_usulan (remove formatting)
            $anggaranUsulan = preg_replace('/[^0-9]/', '', $request->anggaran_usulan);
            $anggaranUsulanNumeric = (float) $anggaranUsulan;

            // Validasi anggaran usulan tidak melebihi nominal usulan dari sesi
            if ($sesi->nominal_usulan && $anggaranUsulanNumeric > $sesi->nominal_usulan) {
                return back()->withErrors([
                    'anggaran_usulan' => 'Anggaran usulan tidak boleh melebihi dana maksimal (Rp ' . number_format($sesi->nominal_usulan, 0, ',', '.') . ')'
                ])->withInput();
            }

            $proposal = ProposalModul::create([
                'sesi_hibah_modul_id' => $sesi->id,
                'user_id' => Auth::id(),
                'judul_modul' => $request->judul_modul,
                'ringkasan_modul' => $request->ringkasan_modul,
                'kata_kunci' => $decodeJsonInput($request->kata_kunci),
                'sdgs_fokus' => $decodeJsonInput($request->sdgs_fokus),
                'sdgs_pendukung' => $decodeJsonInput($request->sdgs_pendukung),
                'file_proposal' => $filePath,
                'status' => 'draft',
                
                // New fields
                'tahun_usulan' => $request->tahun_usulan,
                'tahun_pelaksanaan' => $request->tahun_pelaksanaan,
                'tempat_pelaksanaan' => $request->tempat_pelaksanaan,
                'anggaran_usulan' => $anggaranUsulan,
                'platform_digital' => $request->platform_digital,
                'mitra' => $request->mitra,
                'modul_interdisiplin' => $request->modul_interdisiplin,
                'publikasi_media_massa' => $request->publikasi_media_massa,
                'nama_media_massa' => $request->nama_media_massa,
                'hki' => $request->hki,
                'jenis_hki_dan_judul' => $request->jenis_hki_dan_judul,
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
            'kata_kunci' => 'nullable|json',
            'sdgs_fokus' => 'nullable|json',
            'sdgs_pendukung' => 'nullable|json',
            'file_proposal' => 'nullable|file|mimes:pdf|max:10240',
            
            // New fields
            'tahun_usulan' => 'required|string|max:4',
            'tahun_pelaksanaan' => 'required|string|max:4',
            'tempat_pelaksanaan' => 'required|string|max:255',
            'anggaran_usulan' => 'required|string',
            'platform_digital' => 'required|string|max:255',
            'mitra' => 'nullable|string|max:255',
            'modul_interdisiplin' => 'required|in:Ada,Draft',
            'publikasi_media_massa' => 'required|in:Ada,Draft',
            'nama_media_massa' => 'required_if:publikasi_media_massa,Ada,Draft|nullable|string|max:255',
            'hki' => 'required|in:Ada,Draft',
            'jenis_hki_dan_judul' => 'required_if:hki,Ada,Draft|nullable|string',
            
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

            // Clean anggaran_usulan (remove formatting)
            $anggaranUsulan = preg_replace('/[^0-9]/', '', $request->anggaran_usulan);
            $anggaranUsulanNumeric = (float) $anggaranUsulan;

            // Validasi anggaran usulan tidak melebihi nominal usulan dari sesi
            $sesi = $proposal->sesi;
            if ($sesi->nominal_usulan && $anggaranUsulanNumeric > $sesi->nominal_usulan) {
                return back()->withErrors([
                    'anggaran_usulan' => 'Anggaran usulan tidak boleh melebihi dana maksimal (Rp ' . number_format($sesi->nominal_usulan, 0, ',', '.') . ')'
                ])->withInput();
            }

            $data = [
                'judul_modul' => $request->judul_modul,
                'ringkasan_modul' => $request->ringkasan_modul,
                'kata_kunci' => $decodeJsonInput($request->kata_kunci),
                'sdgs_fokus' => $decodeJsonInput($request->sdgs_fokus),
                'sdgs_pendukung' => $decodeJsonInput($request->sdgs_pendukung),
                
                // New fields
                'tahun_usulan' => $request->tahun_usulan,
                'tahun_pelaksanaan' => $request->tahun_pelaksanaan,
                'tempat_pelaksanaan' => $request->tempat_pelaksanaan,
                'anggaran_usulan' => $anggaranUsulan,
                'platform_digital' => $request->platform_digital,
                'mitra' => $request->mitra,
                'modul_interdisiplin' => $request->modul_interdisiplin,
                'publikasi_media_massa' => $request->publikasi_media_massa,
                'nama_media_massa' => $request->nama_media_massa,
                'hki' => $request->hki,
                'jenis_hki_dan_judul' => $request->jenis_hki_dan_judul,
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

<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComdevProposal;
use App\Models\ComdevSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ComdevSubmisDosenController extends Controller
{
    public function createIdentitas(ComdevProposal $sesi)
    {
        $currentUser = Auth::user();
        return view('subdirektorat-inovasi.dosen.equity.usulkan-proposal-form', compact('sesi', 'currentUser'));
    }

    public function storeIdentitas(Request $request, ComdevProposal $sesi)
    {
        $minAnggota = $sesi->min_anggota > 1 ? $sesi->min_anggota - 1 : 0;
        $maxAnggota = $sesi->max_anggota > 1 ? $sesi->max_anggota - 1 : 0;

        $request->validate([
            'ketua.nama_lengkap'    => 'required|string|max:255',
            'ketua.nik_nim_nip'     => 'required|string|max:50',
            'ketua.alamat_jalan'    => 'required|string|max:255',
            'ketua.provinsi'        => 'required|string',
            'ketua.kota_kabupaten'  => 'required|string',
            'ketua.kecamatan'       => 'required|string',
            'ketua.kelurahan'       => 'required|string',
            'ketua.kode_pos'        => 'nullable|string|max:10',
            'anggota'                   => ['nullable', 'array', "min:$minAnggota", "max:$maxAnggota"],
            'anggota.*.nama_lengkap'    => 'required_with:anggota|string|max:255',
            'anggota.*.nik_nim_nip'     => 'required_with:anggota|string|max:50',
            'anggota.*.alamat_jalan'    => 'required_with:anggota|string|max:255',
            'anggota.*.provinsi'        => 'required_with:anggota|string',
            'anggota.*.kota_kabupaten'  => 'required_with:anggota|string',
            'anggota.*.kecamatan'       => 'required_with:anggota|string',
            'anggota.*.kelurahan'       => 'required_with:anggota|string',
            'anggota.*.kode_pos'        => 'nullable|string|max:10',
        ]);

        DB::beginTransaction();
        try {
            $submission = ComdevSubmission::create([
                'comdev_proposal_id' => $sesi->id,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ]);
            
            $ketuaData = $request->ketua;
            $ketuaData['peran'] = 'Ketua';
            // $ketuaData['provinsi'] = Wilayah::getNamaProvinsi($ketuaData['provinsi']);
            // $ketuaData['kota_kabupaten'] = Wilayah::getNamaKota($ketuaData['kota_kabupaten']);
            // $ketuaData['kecamatan'] = Wilayah::getNamaKecamatan($ketuaData['kecamatan']);
            // $ketuaData['kelurahan'] = Wilayah::getNamaKelurahan($ketuaData['kelurahan']);
            $submission->members()->create($ketuaData);

            if ($request->filled('anggota')) {
                foreach ($request->anggota as $dataAnggota) {
                    $dataAnggota['peran'] = 'Anggota';
                    // $dataAnggota['provinsi'] = Wilayah::getNamaProvinsi($dataAnggota['provinsi']);
                    // $dataAnggota['kota_kabupaten'] = Wilayah::getNamaKota($dataAnggota['kota_kabupaten']);
                    // $dataAnggota['kecamatan'] = Wilayah::getNamaKecamatan($dataAnggota['kecamatan']);
                    // $dataAnggota['kelurahan'] = Wilayah::getNamaKelurahan($dataAnggota['kelurahan']);
                    $submission->members()->create($dataAnggota);
                }
            }
            
            DB::commit();

            return redirect()
                ->route('subdirektorat-inovasi.dosen.equity.proposal.createPengajuan', $submission->id)
                ->with('success', 'Identitas tim berhasil disimpan. Silakan lengkapi detail proposal.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function createPengajuan(ComdevSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id() || $submission->status !== 'draft', 403, 'Akses ditolak.');
        return view('subdirektorat-inovasi.dosen.equity.pengajuan-proposal-form', compact('submission'));
    }

    public function storePengajuan(Request $request, ComdevSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id() || $submission->status !== 'draft', 403, 'Akses ditolak.');
        
        $decodeTagify = fn($json) => empty($json) ? [] : array_column(json_decode($json, true), 'value');

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tahun_usulan' => 'required|digits:4',
            'tempat_pelaksanaan' => 'required|string|max:255',
            'abstrak' => 'required|string|min:50',
            'kata_kunci' => 'required|json',
            'sdgs' => 'required|json',
            'mitra_nasional' => 'nullable|json',
            'mitra_internasional' => 'nullable|json',
            'nominal_usulan' => 'required|string|max:20',
        ]);
        
        $nominal = (int) preg_replace('/[^0-9]/', '', $validated['nominal_usulan']);
        
        $submission->update([
            'judul' => $validated['judul'],
            'tahun_usulan' => $validated['tahun_usulan'],
            'tempat_pelaksanaan' => $validated['tempat_pelaksanaan'],
            'abstrak' => $validated['abstrak'],
            'nominal_usulan' => $nominal,
            'kata_kunci' => $decodeTagify($validated['kata_kunci']),
            'sdgs' => json_decode($validated['sdgs'], true),
            'mitra_nasional' => $decodeTagify($validated['mitra_nasional']),
            'mitra_internasional' => $decodeTagify($validated['mitra_internasional']),
            'status' => 'diajukan',
        ]);

        // PERUBAHAN NAMA ROUTE DI SINI
        return redirect()
            ->route('subdirektorat-inovasi.dosen.equity.manajement.index')
            ->with('success', 'Selamat! Proposal Anda telah berhasil diajukan.');
    }

    public function destroyDraft(ComdevSubmission $submission)
    {
        abort_if($submission->user_id !== Auth::id() || $submission->status !== 'draft', 403, 'Akses ditolak.');
        $submission->delete();
        
        // PERUBAHAN NAMA ROUTE DI SINI JUGA
        return redirect()
            ->route('subdirektorat-inovasi.dosen.equity.manajement.index')
            ->with('success', 'Draft proposal berhasil dihapus.');
    }
}

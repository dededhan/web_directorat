<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComdevProposal;
use App\Models\ComdevSubmission;
use App\Enums\ComdevStatusEnum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // <-- Tambahkan ini untuk error logging
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini untuk file upload
use Illuminate\Support\Facades\Validator; // <-- Tambahkan ini untuk validasi manual

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

        // Debug: Log all request data
        file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Form submitted\n" . json_encode([
            'all_data' => $request->all(),
            'min_anggota' => $minAnggota,
            'max_anggota' => $maxAnggota,
        ], JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

        $validator = \Validator::make($request->all(), [
            'ketua.nama_lengkap'    => 'required|string|max:255',
            'ketua.nik_nim_nip'     => 'nullable|string|max:50',
            'ketua.alamat_jalan'    => 'required|string|max:255',
            'ketua.provinsi'        => 'required|string',
            'ketua.kota_kabupaten'  => 'required|string',
            'ketua.kecamatan'       => 'required|string',
            'ketua.kelurahan'       => 'required|string',
            'ketua.kode_pos'        => 'nullable|string|max:10',
            'anggota'                   => ['nullable', 'array', "min:$minAnggota", "max:$maxAnggota"],
            'anggota.*.nama_lengkap'    => 'nullable|string|max:255',
            'anggota.*.nik_nim_nip'     => 'nullable|string|max:50',
        ], [
            'ketua.nama_lengkap.required' => 'Nama lengkap ketua wajib diisi',
            'ketua.alamat_jalan.required' => 'Alamat jalan wajib diisi',
            'ketua.provinsi.required' => 'Provinsi wajib dipilih',
            'ketua.kota_kabupaten.required' => 'Kota/Kabupaten wajib dipilih',
            'ketua.kecamatan.required' => 'Kecamatan wajib dipilih',
            'ketua.kelurahan.required' => 'Kelurahan wajib dipilih',
            'anggota.min' => "Minimal harus ada $minAnggota anggota tim",
            'anggota.max' => "Maksimal hanya boleh $maxAnggota anggota tim",
        ]);
        
        if ($validator->fails()) {
            file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - VALIDATION FAILED\n" . json_encode([
                'errors' => $validator->errors()->all(),
                'failed_rules' => $validator->failed(),
            ], JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);
            return back()->withErrors($validator)->withInput();
        }
        
        file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Validation passed!\n\n", FILE_APPEND);
        

        DB::beginTransaction();
        try {
            file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Creating submission...\n", FILE_APPEND);
            
            $submission = ComdevSubmission::create([
                'comdev_proposal_id' => $sesi->id,
                'user_id' => Auth::id(),
                'status' => 'draft',
            ]);
            
            file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Submission created: {$submission->id}\n", FILE_APPEND);

            $ketuaData = $request->ketua;
            $ketuaData['peran'] = 'Ketua';
            
            file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Creating ketua member\n", FILE_APPEND);
            $submission->members()->create($ketuaData);

            if ($request->filled('anggota')) {
                foreach ($request->anggota as $index => $dataAnggota) {
                    $dataAnggota['peran'] = 'Anggota';
                    file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Creating anggota $index\n", FILE_APPEND);
                    $submission->members()->create($dataAnggota);
                }
            }

            DB::commit();
            
            file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - Transaction committed! Redirecting...\n", FILE_APPEND);

            return redirect()
                ->route('subdirektorat-inovasi.dosen.equity.proposal.createPengajuan', $submission->id)
                ->with('success', 'Identitas tim berhasil disimpan. Silakan lengkapi detail proposal.');
        } catch (\Exception $e) {
            DB::rollBack();
            file_put_contents(storage_path('logs/form_debug.txt'), date('Y-m-d H:i:s') . " - ERROR: {$e->getMessage()}\n" . $e->getTraceAsString() . "\n\n", FILE_APPEND);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function createPengajuan(ComdevSubmission $submission)
    {
        // abort_if($submission->user_id !== Auth::id() || $submission->status !== 'draft', 403, 'Akses ditolak.');
        return view('subdirektorat-inovasi.dosen.equity.pengajuan-proposal-form', compact('submission'));
    }

    /**
     * Method utama untuk menyimpan detail proposal, termasuk luaran dinamis (Link/File).
     */
    public function storePengajuan(Request $request, ComdevSubmission $submission)
    {
        // Aturan validasi dasar
        $rules = [
            'judul' => 'required|string|max:255',
            'tahun_usulan' => 'required|digits:4',
            'tempat_pelaksanaan' => 'required|string|max:255',
            'abstrak' => 'required|string|min:10',
            'kata_kunci' => 'required|json', // Biarkan json, karena Tagify mengirim format ini
            'sdgs_fokus' => 'required|json',
            'sdgs_pendukung' => 'required|json',
            'mitra_nasional' => 'nullable|json',
            'mitra_internasional' => 'required|json',
            'nominal_usulan' => 'required|string|max:20',
           
        ];

        // ... (Blok validasi luaran Anda sudah benar, tidak perlu diubah) ...
       

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        DB::beginTransaction();
        try {


            // --- FUNGSI DECODE TAGIFY ---
            $decodeTagify = function ($jsonString) {
                if (empty($jsonString)) return [];
                $data = json_decode($jsonString, true);
                // Cek jika hasil decode adalah array dan punya key 'value'
                if (is_array($data) && !empty($data) && isset($data[0]['value'])) {
                    return array_column($data, 'value');
                }
                // Jika sudah array biasa (dari old input), langsung kembalikan
                return $data;
            };

            $nominal = (int) preg_replace('/[^0-9]/', '', $validated['nominal_usulan']);

            // --- BAGIAN UPDATE YANG DIPERBAIKI ---
            $submission->update([
                'judul' => $validated['judul'],
                'tahun_usulan' => $validated['tahun_usulan'],
                'tempat_pelaksanaan' => $validated['tempat_pelaksanaan'],
                'abstrak' => $validated['abstrak'],
                'nominal_usulan' => $nominal,
                'status' => 'diajukan',

                // INI PERBAIKANNYA: Panggil $decodeTagify dengan benar
                'kata_kunci' => $decodeTagify($validated['kata_kunci']),
                'mitra_nasional' => $decodeTagify($validated['mitra_nasional']),
                'mitra_internasional' => $decodeTagify($validated['mitra_internasional']),

                // Data sdgs fokus dan pendukung sudah dalam format array yang benar dari frontend
                'sdgs_fokus' => json_decode($validated['sdgs_fokus'], true),
                'sdgs_pendukung' => json_decode($validated['sdgs_pendukung'], true),

                
            ]);

            $firstModule = $submission->sesi->modules()->orderBy('urutan')->first();
            if ($firstModule) {
                // Cek agar tidak duplikat
                $submission->moduleStatuses()->updateOrCreate(
                    ['comdev_module_id' => $firstModule->id],
                    ['status' => ComdevStatusEnum::DIAJUKAN->value]
                );
            }

            DB::commit();

            return redirect()
                ->route('subdirektorat-inovasi.dosen.equity.manajement.index')
                ->with('success', 'Selamat! Proposal Anda telah berhasil diajukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mengajukan proposal: ' . $e->getMessage() . ' on line ' . $e->getLine());
            return back()->with('error', 'Terjadi kesalahan saat mengajukan proposal. Silakan coba lagi.')->withInput();
        }
    }

    public function destroyDraft(ComdevSubmission $submission)
    {
        // Pastikan hanya pemilik atau admin yang bisa hapus (opsional, tapi best practice)
        // abort_if($submission->user_id !== Auth::id(), 403);

        $submission->delete();

        return redirect()
            ->route('subdirektorat-inovasi.dosen.equity.manajement.index')
            ->with('success', 'Draft proposal berhasil dihapus.');
    }
}

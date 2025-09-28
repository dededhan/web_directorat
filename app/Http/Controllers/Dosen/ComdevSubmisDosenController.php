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
            $submission->members()->create($ketuaData);

            if ($request->filled('anggota')) {
                foreach ($request->anggota as $dataAnggota) {
                    $dataAnggota['peran'] = 'Anggota';
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
            'sdgs' => 'required|json',
            'mitra_nasional' => 'required|json',
            'mitra_internasional' => 'required|json',
            'nominal_usulan' => 'required|string|max:20',
            'luaran_wajib' => 'nullable|array',
            'luaran_opsional' => 'nullable|array',
        ];

        // ... (Blok validasi luaran Anda sudah benar, tidak perlu diubah) ...
        if ($request->has('luaran_wajib')) {
            foreach ($request->get('luaran_wajib') as $key => $val) {
                if (!empty($val['value'])) { // Hanya validasi jika ada value (link atau file)
                    $rules['luaran_wajib.' . $key . '.type'] = 'required|in:link,file';
                    if (isset($val['type']) && $val['type'] == 'link') {
                        $rules['luaran_wajib.' . $key . '.value'] = 'required|url';
                    }
                }
                if ($request->hasFile('luaran_wajib.' . $key . '.value')) {
                    $rules['luaran_wajib.' . $key . '.value'] = 'required|file|mimes:pdf|max:2048';
                }
            }
        }


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $validated = $validator->validated();

        DB::beginTransaction();
        try {
            // --- PROSES FILE LAMA & BARU ---
            $luaranWajibData = $request->input('luaran_wajib', []);
            $originalLuaranWajib = $submission->luaran_wajib ?? [];

            foreach ($luaranWajibData as $index => $item) {
                if (isset($item['deleted']) && $item['deleted'] == 'true' && isset($originalLuaranWajib[$index])) {
                    $fileToDelete = $originalLuaranWajib[$index]['value'] ?? null;
                    if ($fileToDelete) {
                        $pathToDelete = str_replace(Storage::url(''), 'public/', $fileToDelete);
                        if (Storage::exists($pathToDelete)) {
                            Storage::delete($pathToDelete);
                        }
                    }
                }
            }

            $processLuaran = function ($luaranItems, $luaranFiles) {
                // ... (Fungsi processLuaran Anda sudah benar, tidak perlu diubah) ...
                $processed = [];
                if (empty($luaranItems)) return $processed;

                foreach ($luaranItems as $index => $item) {
                    if (isset($item['deleted']) && $item['deleted'] == 'true') {
                        continue;
                    }
                    if ($item['type'] === 'file') {
                        if (isset($luaranFiles[$index]['value'])) {
                            $file = $luaranFiles[$index]['value'];
                            $item['nama_file'] = $file->getClientOriginalName();
                            $path = $file->store('public/luaran_dosen');
                            $item['value'] = Storage::url($path);
                        } elseif (isset($item['value']) && !empty($item['value'])) {
                            $item['nama_file'] = $item['nama_file'] ?? 'file_lama.pdf';
                        } else {
                            continue;
                        }
                    } elseif ($item['type'] === 'link') {
                        if (empty($item['value'])) continue;
                    }
                    unset($item['deleted']);
                    $processed[] = $item;
                }
                return $processed;
            };

            $luaranWajibProcessed = $processLuaran(
                $request->input('luaran_wajib', []),
                $request->file('luaran_wajib', [])
            );

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

                // Data sdgs sudah dalam format array yang benar dari frontend
                'sdgs' => json_decode($validated['sdgs'], true),

                'luaran_wajib' => $luaranWajibProcessed,
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

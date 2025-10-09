<?php

namespace App\Http\Controllers\EquityFakultas;

use App\Http\Controllers\Controller;
use App\Models\JointSupervisionSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class JointSupervisionController extends Controller
{
    public function index()
    {
        $submissions = JointSupervisionSubmission::where('user_id', Auth::id())->latest()->paginate(10);
        return view('equity_fakultas.joint_supervision.index', compact('submissions'));
    }

    public function create()
    {
        return view('equity_fakultas.joint_supervision.create');
    }

    public function show(JointSupervisionSubmission $jointSupervision)
    {
        if ($jointSupervision->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.joint_supervision.show', ['submission' => $jointSupervision]);
    }

    /**
     * Menyimpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf,xlsx,xls|max:2048',
        ]);

        $path = $request->file('proposal_file')->store('proposals/joint_supervision', 'public');

        JointSupervisionSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
            'is_confirmed' => false,
        ]);

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Proposal berhasil diajukan. Silakan konfirmasi untuk mengirim ke admin.');
    }

    public function editDraft(JointSupervisionSubmission $jointSupervision)
    {
        if ($jointSupervision->user_id !== Auth::id() || $jointSupervision->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.joint_supervision.edit_draft', ['submission' => $jointSupervision]);
    }

    public function updateDraft(Request $request, JointSupervisionSubmission $jointSupervision)
    {
        if ($jointSupervision->user_id !== Auth::id() || $jointSupervision->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'nullable|file|mimes:pdf,xlsx,xls|max:2048',
        ]);

        $data = ['nama_pengunggah' => $request->nama_pengunggah];

        if ($request->hasFile('proposal_file')) {
            if ($jointSupervision->proposal_path) {
                Storage::disk('public')->delete($jointSupervision->proposal_path);
            }
            $data['proposal_path'] = $request->file('proposal_file')->store('proposals/joint_supervision', 'public');
        }

        $jointSupervision->update($data);

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Proposal berhasil diperbarui.');
    }

    public function destroy(JointSupervisionSubmission $jointSupervision)
    {
        if ($jointSupervision->user_id !== Auth::id() || $jointSupervision->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        if ($jointSupervision->proposal_path) {
            Storage::disk('public')->delete($jointSupervision->proposal_path);
        }

        $jointSupervision->delete();

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Proposal berhasil dihapus.');
    }

    public function confirm(JointSupervisionSubmission $jointSupervision)
    {
        if ($jointSupervision->user_id !== Auth::id() || $jointSupervision->is_confirmed) {
            abort(403, 'Akses Ditolak');
        }

        $jointSupervision->update([
            'is_confirmed' => true,
            'status' => 'menunggu diverifikasi',
        ]);

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Proposal berhasil dikirim dan menunggu verifikasi admin.');
    }

    /**
     * Menampilkan form untuk melengkapi data (setelah disetujui admin).
     */
    public function edit(JointSupervisionSubmission $jointSupervision)
    {
        // Keamanan: Pastikan hanya pemilik yang bisa edit & statusnya 'disetujui'
        if ($jointSupervision->user_id !== Auth::id() || $jointSupervision->status !== 'disetujui') {
            abort(403, 'Akses Ditolak');
        }
        return view('equity_fakultas.joint_supervision.edit', ['submission' => $jointSupervision]);
    }

    /**
     * Menyimpan data tambahan (bukti keuangan).
     */
    public function update(Request $request, JointSupervisionSubmission $jointSupervision)
    {
        if ($jointSupervision->user_id !== Auth::id() || $jointSupervision->status !== 'disetujui') {
            abort(403, 'Akses Ditolak');
        }

        $request->validate([
            'bukti_keuangan_file' => 'required|file|mimes:pdf|max:2048',
            'laporan_kegiatan_file' => 'required|file|mimes:pdf|max:2048',
        ]);
        
        if ($jointSupervision->bukti_keuangan_path) {
            Storage::disk('public')->delete($jointSupervision->bukti_keuangan_path);
        }
        if ($jointSupervision->laporan_kegiatan_path) {
            Storage::disk('public')->delete($jointSupervision->laporan_kegiatan_path);
        }

        $buktiPath = $request->file('bukti_keuangan_file')->store('bukti_keuangan/joint_supervision', 'public');
        $laporanPath = $request->file('laporan_kegiatan_file')->store('laporan_kegiatan/joint_supervision', 'public');

        $jointSupervision->update([
            'bukti_keuangan_path' => $buktiPath,
            'laporan_kegiatan_path' => $laporanPath,
            'status' => 'selesai',
        ]);

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Data proposal berhasil dilengkapi.');
    }
}
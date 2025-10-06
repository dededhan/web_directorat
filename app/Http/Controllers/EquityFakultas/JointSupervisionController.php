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

    /**
     * Menyimpan pengajuan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pengunggah' => 'required|string|max:255',
            'proposal_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Simpan file ke storage/app/public/proposals/joint_supervision
        $path = $request->file('proposal_file')->store('proposals/joint_supervision', 'public');

        JointSupervisionSubmission::create([
            'user_id' => Auth::id(),
            'nama_pengunggah' => $request->nama_pengunggah,
            'proposal_path' => $path,
            'status' => 'diajukan',
        ]);

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Proposal Joint Supervision berhasil diajukan.');
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
        ]);
        
        // Hapus file lama jika ada untuk mencegah penumpukan file
        if ($jointSupervision->bukti_keuangan_path) {
            Storage::disk('public')->delete($jointSupervision->bukti_keuangan_path);
        }

        $path = $request->file('bukti_keuangan_file')->store('bukti_keuangan/joint_supervision', 'public');

        $jointSupervision->update([
            'bukti_keuangan_path' => $path,
            'status' => 'selesai',
        ]);

        return redirect()->route('equity_fakultas.joint-supervision.index')->with('success', 'Data proposal berhasil dilengkapi.');
    }
}
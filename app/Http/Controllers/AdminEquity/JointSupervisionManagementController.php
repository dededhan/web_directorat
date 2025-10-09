<?php

namespace App\Http\Controllers\AdminEquity;

use App\Http\Controllers\Controller;
use App\Models\JointSupervisionSubmission; // <-- Ganti Model
use Illuminate\Http\Request;

class JointSupervisionManagementController extends Controller
{
    /**
     * Menampilkan semua proposal Joint Supervision untuk diverifikasi.
     */
    public function index()
    {
        $submissions = JointSupervisionSubmission::with('user.profile.fakultas')->latest()->paginate(10);
        // Pastikan Anda membuat folder view 'joint_supervision' di dalam 'admin_equity'
        return view('admin_equity.joint_supervision.index', compact('submissions'));
    }

    /**
     * Menampilkan detail satu proposal.
     */
    public function show(JointSupervisionSubmission $submission)
    {
        $submission->load('user.profile.fakultas');
        return view('admin_equity.joint_supervision.show', compact('submission'));
    }

    /**
     * Mengubah status proposal.
     */
    public function updateStatus(Request $request, JointSupervisionSubmission $submission)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,disetujui,ditolak',
            'catatan_admin' => 'nullable|string',
        ]);

        $submission->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return redirect()->route('admin_equity.joint-supervision.index')->with('success', 'Status proposal berhasil diubah.');
    }

    /**
     * Export data ke Excel
     */
    public function export()
    {
        $submissions = JointSupervisionSubmission::with('user.profile.fakultas')->get();
        
        $fileName = 'joint_supervision_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'No',
                'Fakultas',
                'Nama Pengunggah',
                'Tanggal Diajukan',
                'Status',
                'Catatan Admin',
                'File Proposal',
                'File Bukti Keuangan',
                'File Laporan Kegiatan'
            ]);

            // Data
            foreach ($submissions as $index => $submission) {
                fputcsv($file, [
                    $index + 1,
                    $submission->user->profile->fakultas->name ?? '-',
                    $submission->nama_pengunggah,
                    $submission->created_at->format('d/m/Y H:i'),
                    ucfirst($submission->status),
                    $submission->catatan_admin ?? '-',
                    $submission->proposal_path ? url('storage/' . $submission->proposal_path) : '-',
                    $submission->bukti_keuangan_path ? url('storage/' . $submission->bukti_keuangan_path) : '-',
                    $submission->laporan_kegiatan_path ? url('storage/' . $submission->laporan_kegiatan_path) : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
use App\Models\Logbook;
use Illuminate\Http\Request;

class ComdevLogbookController extends Controller
{
    /**
     * Menampilkan halaman logbook untuk submission tertentu.
     */
    public function index(ComdevSubmission $submission)
    {
        // Memastikan hanya pemilik proposal yang bisa mengakses
        // if ($submission->user_id !== auth()->id()) {
        //     abort(403);
        // }

        // Mengambil semua logbook yang berelasi dengan submission ini
        $logbooks = $submission->logbooks()->orderBy('activity_date', 'desc')->get();

        // Mengirim data submission dan logbooks ke view
        return view('subdirektorat-inovasi.dosen.equity.logbook', [
            'submission' => $submission,
            'logbooks' => $logbooks,
        ]);
    }

    /**
     * Menyimpan entri logbook baru.
     */
    public function store(Request $request, ComdevSubmission $submission)
    {
        // Mengambil persentase terakhir untuk validasi
        $latestPercentage = $submission->logbooks()->max('progress_percentage') ?? 0;

        // Validasi input dari form
        $validated = $request->validate([
            'activity_date' => 'required|date',
            'notes' => 'required|string|min:10',
            // Aturan validasi: persen harus lebih besar atau sama dengan persen terakhir
            'progress_percentage' => "required|integer|min:{$latestPercentage}|max:100",
            'attachment' => 'nullable|file|mimes:pdf,docx,xlsx,png,jpg|max:2048', // max 2MB
        ], [
            // Pesan error kustom
            'progress_percentage.min' => 'Persentase capaian tidak boleh lebih rendah dari entri sebelumnya.',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('logbook_attachments', 'public');
            $validated['attachment_path'] = $path;
        }

        // Menyimpan data logbook baru yang berelasi dengan submission
        $submission->logbooks()->create($validated);

        // Kembali ke halaman logbook dengan pesan sukses
        return redirect()->route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id)
            ->with('success', 'Catatan logbook berhasil ditambahkan.');
    }
}

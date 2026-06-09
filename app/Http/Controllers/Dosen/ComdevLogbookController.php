<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ComdevSubmission;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'notes' => 'required|string|min:1',
            // Aturan validasi: persen harus lebih besar atau sama dengan persen terakhir
            'progress_percentage' => "required|integer|min:{$latestPercentage}|max:100",
            'attachment' => 'nullable|file|mimes:pdf,docx,xlsx,png,jpg|max:2048', // max 2MB
        ], [
            // Pesan error kustom
            'progress_percentage.min' => 'Persentase capaian tidak boleh lebih rendah dari entri sebelumnya.',
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $date = now()->format('Y-m-d');
            $timestamp = now()->timestamp;
            $filename = "logbook_{$submission->id}_{$date}_{$timestamp}.{$ext}";
            $path = $file->storeAs('logbook_attachments', $filename, 'public');
            $validated['attachment_path'] = $path;
        }

        // Menyimpan data logbook baru yang berelasi dengan submission
        $submission->logbooks()->create($validated);

        // Kembali ke halaman logbook dengan pesan sukses
        return redirect()->route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id)
            ->with('success', 'Catatan logbook berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail logbook.
     */
    public function show(Logbook $logbook)
    {
        $logbook->load('comdevSubmission');
        return view('subdirektorat-inovasi.dosen.equity.logbook_detail', [
            'logbook' => $logbook,
            'submission' => $logbook->comdevSubmission,
        ]);
    }

    /**
     * Menampilkan form edit logbook.
     */
    public function edit(Logbook $logbook)
    {
        $logbook->load('comdevSubmission');
        return view('subdirektorat-inovasi.dosen.equity.logbook_edit', [
            'logbook' => $logbook,
            'submission' => $logbook->comdevSubmission,
        ]);
    }

    /**
     * Mengupdate logbook yang ada.
     */
    public function update(Request $request, Logbook $logbook)
    {
        $submission = $logbook->comdevSubmission;

        // Cari logbook sebelumnya berdasarkan tanggal (untuk validasi persentase)
        $previousLogbook = $submission->logbooks()
            ->where('activity_date', '<', $logbook->activity_date)
            ->orderBy('activity_date', 'desc')
            ->first();

        $minPercentage = $previousLogbook ? $previousLogbook->progress_percentage : 0;

        $validated = $request->validate([
            'activity_date' => 'required|date',
            'notes' => 'required|string|min:1',
            'progress_percentage' => "required|integer|min:{$minPercentage}|max:100",
            'attachment' => 'nullable|file|mimes:pdf,docx,xlsx,png,jpg|max:2048',
        ], [
            'progress_percentage.min' => "Persentase capaian tidak boleh lebih rendah dari logbook sebelumnya ({$minPercentage}%).",
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Hapus file lama jika ada
            if ($logbook->attachment_path) {
                Storage::disk('public')->delete($logbook->attachment_path);
            }
            $file = $request->file('attachment');
            $ext = $file->getClientOriginalExtension();
            $date = now()->format('Y-m-d');
            $timestamp = now()->timestamp;
            $filename = "logbook_{$submission->id}_{$date}_{$timestamp}.{$ext}";
            $path = $file->storeAs('logbook_attachments', $filename, 'public');
            $validated['attachment_path'] = $path;
        }

        $logbook->update($validated);

        return redirect()->route('subdirektorat-inovasi.dosen.equity.logbook', $submission->id)
                         ->with('success', 'Catatan logbook berhasil diperbarui.');
    }

    /**
     * Menghapus logbook.
     */
    public function destroy(Logbook $logbook)
    {
        // Hapus file attachment jika ada
        if ($logbook->attachment_path) {
            Storage::disk('public')->delete($logbook->attachment_path);
        }

        $logbook->delete();

        return redirect()->back()->with('success', 'Catatan logbook berhasil dihapus.');
    }
}

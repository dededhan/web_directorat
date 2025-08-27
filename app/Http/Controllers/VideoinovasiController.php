<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoinovasiController extends Controller
{
    /**
     * Menampilkan halaman manajemen video.
     */
    public function index()
    {
        // Ambil data video pertama (karena hanya ada satu)
        $video = Video::first();
        return view('admin.inovasivideo', compact('video'));
    }

    /**
     * Menyimpan atau memperbarui data video.
     */
    public function storeOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:youtube,mp4',
            'path' => 'required_if:type,youtube|nullable|string',
            'video_file' => 'required_if:type,mp4|nullable|file|mimes:mp4|max:20480', // Max 20MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Dapatkan data video yang ada atau buat instance baru
        $video = Video::first() ?? new Video();

        $data = $request->only(['title', 'description', 'type']);

        if ($request->type == 'youtube') {
            // Ekstrak YouTube Video ID dari URL
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->path, $match);
            $data['path'] = $match[1] ?? $request->path; // Simpan ID-nya saja
        } 
        elseif ($request->type == 'mp4' && $request->hasFile('video_file')) {
            // Hapus file lama jika ada
            if ($video->exists && $video->type == 'mp4' && Storage::disk('public')->exists($video->path)) {
                Storage::disk('public')->delete($video->path);
            }

            // Simpan file baru
            $filePath = $request->file('video_file')->store('videos', 'public');
            $data['path'] = $filePath;
        }

        // Simpan atau perbarui data
        $video->fill($data)->save();

        return redirect()->route('admin.video.index')->with('success', 'Video Sambutan Pimpinan berhasil diperbarui.');
    }
  
    public function destroy()
    {
        // Cari satu-satunya video yang ada
        $video = Video::first();

        // Jika video ditemukan
        if ($video) {
            // Jika tipenya mp4, hapus juga file fisiknya dari storage
            if ($video->type == 'mp4' && Storage::disk('public')->exists($video->path)) {
                Storage::disk('public')->delete($video->path);
            }

            // Hapus record dari database
            $video->delete();

            return redirect()->route('admin.video.index')->with('success', 'Video Sambutan Pimpinan berhasil dihapus.');
        }

        // Redirect jika video tidak ditemukan
        return redirect()->route('admin.video.index')->with('error', 'Video tidak ditemukan.');
    }
}
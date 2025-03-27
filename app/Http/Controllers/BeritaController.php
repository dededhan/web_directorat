<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBeritaRequest;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::latest()->get();
        return view('admin.newsadmin', compact('beritas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeritaRequest $request)
    {
        try {
            // Validation already handled by StoreBeritaRequest

            // Check if image exists and is valid
            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                // Generate unique file name
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();

                // Store the file in the public disk under berita-images folder
                $gambarPath = $request->file('gambar')->storeAs(
                    'berita-images',
                    $namaFile,
                    'public'
                );

                // Create the berita record with the image path
                Berita::create([
                    'kategori' => $request->kategori,
                    'tanggal' => $request->tanggal,
                    'judul' => $request->judul_berita,
                    'isi' => $request->isi_berita,
                    'gambar' => $gambarPath
                ]);

                return redirect()->route('admin.news.index')
                    ->with('success', 'Berita berhasil disimpan!');
            } else {
                // Handle the case where image upload failed
                return redirect()->back()
                    ->with('error', 'Upload gambar gagal. Pastikan file gambar valid.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            // Log the error and return with error message
            \Log::error('Error storing news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan berita: ' . $e->getMessage())
                ->withInput();
        }
    }
    /**
     * Display news on the home page.
     */
    public function homeNews()
    {
        // Get regular news for the main grid (latest 3)
        $regularNews = Berita::latest()->take(3)->get();

        // Get featured news for the carousel (latest 5)
        $featuredNews = Berita::latest()->take(5)->get();

        return view('home', compact('regularNews', 'featuredNews'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('Berita.show', compact('berita'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Delete the image file from storage
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            // Delete the record
            $berita->delete();

            return redirect()->route('admin.news.index')
                ->with('success', 'Berita berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }
}

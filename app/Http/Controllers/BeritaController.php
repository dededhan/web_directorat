<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBeritaRequest;
use App\Models\Pengumuman;
use App\Models\ProgramLayanan;
use Illuminate\Support\Facades\Storage;
use App\Models\Instagram;

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
        // Regular
        $regularNews = Berita::latest()->take(3)->get();

        // Features
        $featuredNews = Berita::latest()->take(5)->get();

        // Scroll
        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active program layanan
        $programLayanan = ProgramLayanan::where('status', 1)
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        // Get Instagram posts for the homepage
        $instagramPosts = Instagram::orderBy('created_at', 'desc')->take(3)->get();

        return view('home', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
    }
    public function getBeritaDetail($id)
    {
        $berita = Berita::findOrFail($id);
        return response()->json($berita);
    }

    /**
     * Display news by category.
     */
    public function kategori(string $kategori)
    {
        // Validate the category
        if (!in_array($kategori, ['inovasi', 'pemeringkatan'])) {
            return redirect()->route('berita.all')
                ->with('error', 'Kategori tidak valid.');
        }

        $beritas = Berita::where('kategori', $kategori)
            ->latest()
            ->paginate(9); // Show 9 news per page

        $pageTitle = 'Berita ' . ucfirst($kategori);

        return view('Berita.beritahome', compact('beritas', 'pageTitle'));
    }

    public function allNews()
    {
        $beritas = Berita::latest()->paginate(9); // Show 9 news per page
        return view('Berita.beritahome', compact('beritas'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Get active announcements
        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Berita.show', compact('berita', 'announcements'));
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

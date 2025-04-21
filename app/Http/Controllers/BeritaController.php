<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBeritaRequest;
use App\Models\BeritaImage;
use App\Models\Pengumuman;
use App\Models\ProgramLayanan;
use Illuminate\Support\Facades\Storage;
use App\Models\Instagram;

class BeritaController extends Controller
{
    /**
     * Get the correct route name prefix based on authenticated user role
     */
    private function getRoutePrefix()
    {
        if (auth()->user()->role === 'admin_direktorat') {
            return 'admin';
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        } else if (auth()->user()->role === 'admin_inovasi') {
            return 'subdirektorat-inovasi.admin_inovasi';
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }

        return 'admin';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::latest()->get();
        $routePrefix = $this->getRoutePrefix();

        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.newsadmin', compact('beritas', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return view('subdirektorat-inovasi.admin_hilirisasi.newsadmin', compact('beritas', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_inovasi') {
            return view('subdirektorat-inovasi.admin_inovasi.newsadmin', compact('beritas', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.newsadmin', compact('beritas', 'routePrefix'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeritaRequest $request)
    {
        try {
            // Check if image exists and is valid
            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'berita-images',
                    $namaFile,
                    'public'
                );

                // Create the berita record with the image path
                $berita = Berita::create([
                    'kategori' => $request->kategori,
                    'tanggal' => $request->tanggal,
                    'judul' => $request->judul_berita,
                    'isi' => $request->isi_berita,
                    'gambar' => $gambarPath
                ]);

                if ($request->hasFile('additional_images')) {
                    foreach ($request->file('additional_images') as $image) {
                        $namaAdditionalFile = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $additionalPath = $image->storeAs(
                            'berita-images',
                            $namaAdditionalFile,
                            'public'
                        );

                        BeritaImage::create([
                            'berita_id' => $berita->id,
                            'path' => $additionalPath
                        ]);
                    }
                }

                $routePrefix = $this->getRoutePrefix();
                return redirect()->route($routePrefix . '.news.index')
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
        $featuredNews = Berita::latest()->take(6)->get();

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

    public function landingPagePemeringkatan()
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

        return view('Pemeringkatan.LandingPagePemeringkatan', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
    }

    //function display news inovasi
    public function landingPageInovasi()
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

        return view('subdirektorat-inovasi.LandingPageHilirisasi', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
    }

    /**
     * Display news by category.
     */
    public function kategori(string $kategori)
    {
        // Validate the category
        if (!in_array($kategori, ['inovasi', 'pemeringkatan', 'umum'])) {
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

    public function show(string $slug)
    {
        // First try to find by slug
        $berita = Berita::where('slug', $slug)->first();

        // If not found and looks like an ID, try finding by ID
        if (!$berita && is_numeric($slug)) {
            $berita = Berita::find($slug);
        }

        // If still not found, abort
        if (!$berita) {
            abort(404, 'Berita tidak ditemukan');
        }

        $relatedNews = Berita::where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->latest()
            ->take(3)
            ->get();

        $latestNews = Berita::latest()->take(4)->get();
        $popularNews = Berita::latest()->take(5)->get();

        return view('Berita.sampleberita', compact('berita', 'relatedNews', 'latestNews', 'popularNews'));
    }

    public function getBeritaDetail($title_or_id)
    {
        if (is_numeric($title_or_id)) {
            $berita = Berita::findOrFail($title_or_id);
        } else {
            $title = str_replace('-', ' ', $title_or_id);
            $berita = Berita::where('judul', 'LIKE', "%{$title}%")->firstOrFail();
        }

        return response()->json($berita);
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

            // Delete additional images if they exist
            if ($berita->additionalImages) {
                foreach ($berita->additionalImages as $image) {
                    if (Storage::disk('public')->exists($image->path)) {
                        Storage::disk('public')->delete($image->path);
                    }
                    $image->delete();
                }
            }

            // Delete the record
            $berita->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.news.index')
                ->with('success', 'Berita berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus berita: ' . $e->getMessage());
        }
    }

    // app/Http/Controllers/BeritaController.php
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('upload')->store('news_images', 'public');
        $url = Storage::url($path);

        return response()->json([
            'url' => asset($url),
        ]);
    }

    public function update(Request $request, string $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'kategori' => 'required|in:inovasi,pemeringkatan,umum',
                'tanggal' => 'required|date',
                'judul_berita' => 'required|string|max:200',
                'isi_berita' => 'required|string',
                'gambar' => 'nullable|image|max:2048',
            ]);

            // Update the text fields
            $berita->kategori = $validated['kategori'];
            $berita->tanggal = $validated['tanggal'];
            $berita->judul = $validated['judul_berita'];
            $berita->isi = $validated['isi_berita'];

            // Handle image update if a new one was uploaded
            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                // Delete old image
                if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                    Storage::disk('public')->delete($berita->gambar);
                }

                // Store new image
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'berita-images',
                    $namaFile,
                    'public'
                );

                $berita->gambar = $gambarPath;
            }

            $berita->save();

            $routePrefix = $this->getRoutePrefix();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Berita berhasil diperbarui!']);
            }

            return redirect()->route($routePrefix . '.news.index')
                ->with('success', 'Berita berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating news: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui berita: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui berita: ' . $e->getMessage())
                ->withInput();
        }
    }
}

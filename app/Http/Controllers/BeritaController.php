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
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use Illuminate\Support\Str; // Import the Str class for slug generation

class BeritaController extends Controller
{
    private function getRoutePrefix()
    {
        $role = auth()->user()->role;
        switch ($role) {
            case 'admin_direktorat':
                return 'admin';
            case 'admin_hilirisasi':
                return 'subdirektorat-inovasi.admin_hilirisasi';
            case 'admin_inovasi':
                return 'subdirektorat-inovasi.admin_inovasi';
            case 'admin_pemeringkatan':
                return 'admin_pemeringkatan';
            case 'fakultas':
                return 'fakultas';
            case 'prodi':
                return 'prodi';
            default:
                return 'admin';
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::with('user')->latest()->get();
        $routePrefix = $this->getRoutePrefix();
        $viewName = 'admin.newsadmin';

        $role = auth()->user()->role;
        if ($role === 'admin_hilirisasi') {
            $viewName = 'subdirektorat-inovasi.admin_hilirisasi.newsadmin';
        } elseif ($role === 'admin_inovasi') {
            $viewName = 'subdirektorat-inovasi.admin_inovasi.newsadmin';
        } elseif ($role === 'admin_pemeringkatan') {
            $viewName = 'admin_pemeringkatan.newsadmin';
        } elseif ($role === 'admin_direktorat') {
            $viewName = 'admin.newsadmin';
        } elseif ($role === 'fakultas') {
            $viewName = 'fakultas.newsadmin';
        } elseif ($role === 'prodi') {
            $viewName = 'prodi.newsadmin';
        }
        return view($viewName, compact('beritas', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     * ENHANCEMENT: Added data purification and unique slug generation.
     */
    public function store(StoreBeritaRequest $request)
    {
        try {
            // The StoreBeritaRequest already validates the input, which is the first line of defense.
            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'berita-images',
                    $namaFile,
                    'public'
                );
                
                // Security: Sanitize rich text and title inputs to prevent XSS attacks.
                $cleanJudul = Purifier::clean($request->judul_berita);
                $cleanIsi = Purifier::clean($request->isi_berita);

                // Robustness: Create a unique slug from the title for clean URLs and reliable lookup.
                $slug = $this->createUniqueSlug($cleanJudul);

                // Create the berita record with the sanitized and prepared data
                $berita = Berita::create([
                    'user_id' => Auth::id(),
                    'kategori' => $request->kategori,
                    'tanggal' => $request->tanggal,
                    'judul' => $cleanJudul,
                    'isi' => $cleanIsi,
                    'slug' => $slug, // Save the generated slug
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
                return redirect()->back()
                    ->with('error', 'Upload gambar gagal. Pastikan file gambar valid.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            \Log::error('Error storing news: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan berita: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Creates a unique slug for a Berita item.
     *
     * @param string $title
     * @param int $excludeId
     * @return string
     */
    private function createUniqueSlug(string $title, int $excludeId = 0): string
    {
        $slug = Str::slug($title, '-');
        $originalSlug = $slug;
        $count = 1;

        // Loop until a unique slug is found. The 'where' clause ensures we don't conflict
        // with other records, and '!= excludeId' allows the update operation to work correctly.
        while (Berita::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /**
     * Display the specified resource.
     * ENHANCEMENT: Now reliably finds news by its unique slug.
     */
    public function show(string $slug)
    {
        // Security: Finding by a unique slug is more secure and reliable than using an ID or partial title.
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // The 'isi' (content) of the news is rendered in the view.
        // Because we sanitized it with Purifier before saving, it is safe to render with {!! !!} in Blade.

        $relatedNews = Berita::where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->latest()
            ->take(3)
            ->get();

        $latestNews = Berita::latest()->take(4)->get();
        $popularNews = Berita::latest()->take(5)->get();

        return view('Berita.sampleberita', compact('berita', 'relatedNews', 'latestNews', 'popularNews'));
    }
    
    /**
     * Fetches details for a specific news item for the edit modal.
     * ENHANCEMENT: Simplified to fetch by ID only, making it more secure and efficient.
     */
    public function getBeritaDetail($id)
    {
        // Security: Removed title-based searching (`LIKE`) to prevent potential SQL injection vectors
        // and improve performance. Relying on the unique ID is best practice.
        $berita = Berita::findOrFail($id);
        return response()->json($berita);
    }
    
    /**
     * Update the specified resource in storage.
     * ENHANCEMENT: Added data purification and slug regeneration on title change.
     */
    public function update(Request $request, string $id)
    {
        try {
            $berita = Berita::findOrFail($id);

            // Security: Validate all incoming data.
            $validated = $request->validate([
                'kategori' => 'required|in:inovasi,pemeringkatan,umum,fakultas,prodi',
                'tanggal' => 'required|date',
                'judul_berita' => 'required|string|max:200',
                'isi_berita' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Security: Sanitize inputs to prevent XSS, same as in the store method.
            $cleanJudul = Purifier::clean($validated['judul_berita']);
            $cleanIsi = Purifier::clean($validated['isi_berita']);

            // Update the model's attributes
            $berita->kategori = $validated['kategori'];
            $berita->tanggal = $validated['tanggal'];
            $berita->judul = $cleanJudul;
            $berita->isi = $cleanIsi;
            
            // Robustness: If the title was changed, regenerate the slug to keep the URL current.
            if ($berita->isDirty('judul')) {
                $berita->slug = $this->createUniqueSlug($cleanJudul, $berita->id);
            }

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
    
    // The methods below are unchanged as they were not the focus of the security enhancement.

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

    public function homeNews()
    {
        $countRegularNews = 3;
        $regularNews = Berita::latest()
            ->take($countRegularNews)
            ->get();
        $regularNewsIds = $regularNews->pluck('id')->toArray();

        $countFeaturedCarousel = 10;
        $featuredNews = Berita::whereNotIn('id', $regularNewsIds)
            ->latest()
            ->take($countFeaturedCarousel)
            ->get();
        
        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $programLayanan = ProgramLayanan::where('status', 1)
            ->orderBy('id', 'desc')
            ->get();

        $instagramPosts = Instagram::orderBy('created_at', 'desc')->take(3)->get();

        return view('home', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
    }

    public function landingPagePemeringkatan()
    {
        $categoryName = 'pemeringkatan';
        $countRegularNews = 3;
        $countFeaturedNews = 5;

        $regularNews = Berita::where('kategori', $categoryName)
            ->latest()
            ->take($countRegularNews)
            ->get();

        $featuredNews = Berita::where('kategori', $categoryName)
            ->latest()
            ->skip($countRegularNews)
            ->take($countFeaturedNews)
            ->get();

        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $programLayanan = ProgramLayanan::where('status', 1)
            ->where('kategori', 'pemeringkatan')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        $instagramPosts = Instagram::orderBy('created_at', 'desc')->take(3)->get();

        return view('Pemeringkatan.LandingPagePemeringkatan', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
    }

    public function landingPageInovasi()
    {
        $categoryName = 'inovasi';
        $countRegularNews = 3;
        $countFeaturedNews = 5;

        $regularNews = Berita::where('kategori', $categoryName)
            ->latest()
            ->take($countRegularNews)
            ->get();

        $featuredNews = Berita::where('kategori', $categoryName)
            ->latest()
            ->skip($countRegularNews)
            ->take($countFeaturedNews)
            ->get();

        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $programLayanan = ProgramLayanan::where('status', 1)
            ->where('kategori', 'inovasi')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        $instagramPosts = Instagram::orderBy('created_at', 'desc')->take(3)->get();

        return view('subdirektorat-inovasi.LandingPageHilirisasi', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
    }

    public function kategori(string $kategori)
    {
        if (!in_array($kategori, ['inovasi', 'pemeringkatan', 'umum'])) {
            return redirect()->route('berita.all')
                ->with('error', 'Kategori tidak valid.');
        }

        $beritas = Berita::where('kategori', $kategori)
            ->latest()
            ->paginate(9);

        $pageTitle = 'Berita ' . ucfirst($kategori);

        return view('Berita.beritahome', compact('beritas', 'pageTitle'));
    }

    public function allNews()
    {
        $beritas = Berita::latest()->paginate(9);
        return view('Berita.beritahome', compact('beritas'));
    }
}
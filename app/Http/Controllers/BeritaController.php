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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use App\Services\TranslationService; 

class BeritaController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

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


    public function index()
    {

        if (!Gate::allows('viewAny', Berita::class)) {
            abort(403, 'Unauthorized access');
        }
        
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


    public function store(StoreBeritaRequest $request)
    {
        try {
        
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');

                $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    return redirect()->back()
                        ->with('error', 'Format file tidak diizinkan. Hanya JPG, PNG, dan GIF yang diperbolehkan.')
                        ->withInput();
                }
                

                if ($file->getSize() > 2048 * 1024) {
                    return redirect()->back()
                        ->with('error', 'Ukuran file terlalu besar. Maksimal 2MB.')
                        ->withInput();
                }
                
                $namaFile = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $gambarPath = $file->storeAs(
                    'berita-images',
                    $namaFile,
                    'public'
                );
                

                $cleanJudul = strip_tags($request->judul_berita);
                $cleanIsi = Purifier::clean($request->isi_berita);

       
                try {
                    $judulEn = $this->translationService->translateToEnglish($cleanJudul);
                    $isiEn = $this->translationService->translateHtml($cleanIsi, 'en');
                } catch (\Exception $e) {
                    \Log::warning('Translation failed, using original text: ' . $e->getMessage());
                    $judulEn = $cleanJudul;
                    $isiEn = $cleanIsi;
                }

    
                $slug = $this->createUniqueSlug($cleanJudul);


                $berita = Berita::create([
                    'user_id' => auth()->id(),
                    'kategori' => $request->kategori,
                    'tanggal' => $request->tanggal,
                    'judul' => $cleanJudul,
                    'judul_en' => $judulEn,
                    'isi' => $cleanIsi,
                    'isi_en' => $isiEn, 
                    'slug' => $slug, 
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
    

    private function createUniqueSlug(string $title, int $excludeId = 0): string
    {
        $slug = Str::slug($title, '-');
        $originalSlug = $slug;
        $count = 1;


        while (Berita::where('slug', $slug)->where('id', '!=', $excludeId)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }


    public function show(string $slug)
    {

        $berita = Berita::where('slug', $slug)->firstOrFail();



        $relatedNews = Berita::where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->latest()
            ->take(3)
            ->get();

        $latestNews = Berita::latest()->take(4)->get();
        $popularNews = Berita::latest()->take(5)->get();

        return view('Berita.sampleberita', compact('berita', 'relatedNews', 'latestNews', 'popularNews'));
    }
    

    public function getBeritaDetail($id)
    {

        $berita = Berita::findOrFail($id);
        return response()->json($berita);
    }
    

    public function update(Request $request, string $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            

            if (!in_array(auth()->user()->role, ['admin_direktorat', 'admin_hilirisasi', 'admin_inovasi', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
                return redirect()->back()
                    ->with('error', 'Anda tidak memiliki izin untuk mengedit berita ini.');
            }


            $validated = $request->validate([
                'kategori' => 'required|in:inovasi,pemeringkatan,umum,fakultas,prodi',
                'tanggal' => 'required|date',
                'judul_berita' => 'required|string|max:200',
                'isi_berita' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);


            $cleanJudul = strip_tags($validated['judul_berita']);
            $cleanIsi = Purifier::clean($validated['isi_berita']);

   
            try {
                $judulEn = $this->translationService->translateToEnglish($cleanJudul);
                $isiEn = $this->translationService->translateHtml($cleanIsi, 'en');
            } catch (\Exception $e) {
                \Log::warning('Translation failed, using original text: ' . $e->getMessage());
                $judulEn = $cleanJudul;
                $isiEn = $cleanIsi;
            }

            // Update the model's attributes
            $berita->kategori = $validated['kategori'];
            $berita->tanggal = $validated['tanggal'];
            $berita->judul = $cleanJudul;
            $berita->judul_en = $judulEn; 
            $berita->isi = $cleanIsi;
            $berita->isi_en = $isiEn;
            

            if ($berita->isDirty('judul')) {
                $berita->slug = $this->createUniqueSlug($cleanJudul, $berita->id);
            }


            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {

                if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                    Storage::disk('public')->delete($berita->gambar);
                }


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


    public function destroy(string $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            // Security: Only admins can delete berita
            if (!in_array(auth()->user()->role, ['admin_direktorat', 'admin_hilirisasi', 'admin_inovasi', 'admin_pemeringkatan', 'fakultas', 'prodi'])) {
                return redirect()->back()
                    ->with('error', 'Anda tidak memiliki izin untuk menghapus berita ini.');
            }


            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }

            if ($berita->additionalImages) {
                foreach ($berita->additionalImages as $image) {
                    if (Storage::disk('public')->exists($image->path)) {
                        Storage::disk('public')->delete($image->path);
                    }
                    $image->delete();
                }
            }

 
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

    /**
     * Pemeringkatan landing page - shows news and programs for pemeringkatan section
     */
    public function pemeringkatanLanding()
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

        return view('pemeringkatan.landing', compact('regularNews', 'featuredNews', 'announcements', 'programLayanan', 'instagramPosts'));
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
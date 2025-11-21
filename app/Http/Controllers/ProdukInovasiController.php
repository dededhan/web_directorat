<?php

namespace App\Http\Controllers;

use App\Models\ProdukInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\ProdukInovasiVideo;
use App\Models\MitraKolaborasi;
use App\Services\TranslationService;
use Illuminate\Support\Facades\DB;


class ProdukInovasiController extends Controller
{

    private function getRoutePrefix()
    {
        if (auth()->user()->hasRole('admin_direktorat')) {
            return 'admin';
        } else if (auth()->user()->hasRole('admin_hilirisasi')) {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        }

        return 'admin';
    }


    public function index()
    {
        $produkInovasi = ProdukInovasi::with('videos')->get();
        $routePrefix = $this->getRoutePrefix();

        $view = auth()->user()->hasRole('admin_hilirisasi')
            ? 'subdirektorat-inovasi.admin_hilirisasi.produk_inovasi'
            : 'admin.produk_inovasi';
            
        return view($view, compact('produkInovasi', 'routePrefix'));
    }

    public function show(ProdukInovasi $produk)
    {
        return view('subdirektorat-inovasi.riset_unj.produk_inovasi.show', compact('produk'));
    }

    public function publicIndex()
    {
        $produkInovasi = ProdukInovasi::latest()->get();
        $beritaInovasi = Berita::where('kategori', 'inovasi')->latest()->take(4)->get();
        $video = ProdukInovasiVideo::latest()->first(); // Corrected model and gets the latest
        $semuaMitra = MitraKolaborasi::all();

        return view('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi', compact(
            'produkInovasi', 'beritaInovasi', 'video', 'semuaMitra'
        ));
    }

    public function showMitraByCategory(Request $request)
    {
        $kategoriSlug = $request->query('kategori', 'pendidikan');

        $kategoriMapping = [
            'pendidikan' => 'Pendidikan',
            'sains-teknologi' => 'Sains & Teknologi',
            'sosial-humaniora-seni' => 'Sosial Humaniora & Seni',
            'kesehatan-psikologi' => 'Kesehatan & Psikologi',
        ];

        $detailData = [
             'pendidikan' => ['title' => 'Pendidikan', 'icon' => 'fa-school', 'description' => 'Kolaborasi strategis dengan berbagai institusi pendidikan untuk meningkatkan mutu pembelajaran...'],
             'sains-teknologi' => ['title' => 'Sains & Teknologi', 'icon' => 'fa-flask', 'description' => 'Bermitra dengan industri teknologi terdepan dan lembaga riset untuk mendorong batas-batas inovasi...'],
             'sosial-humaniora-seni' => ['title' => 'Sosial Humaniora & Seni', 'icon' => 'fa-palette', 'description' => 'Menggali potensi kreativitas dan kearifan lokal melalui kolaborasi di bidang sosial, humaniora, dan seni...'],
             'kesehatan-psikologi' => ['title' => 'Kesehatan & Psikologi', 'icon' => 'fa-heart-pulse', 'description' => 'Bekerja sama dengan institusi kesehatan dan para ahli untuk menciptakan inovasi terapan...'],
        ];

        $kategoriDB = $kategoriMapping[$kategoriSlug] ?? 'Pendidikan';
        $partners = MitraKolaborasi::where('kategori', $kategoriDB)->get();
        $data = $detailData[$kategoriSlug] ?? $detailData['pendidikan'];

        return view('subdirektorat-inovasi.riset_unj.produk_inovasi.mitra-kolaborasi', compact('data', 'partners'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'inovator' => 'required|array|min:1',
            'inovator.*' => 'required|string|max:255',
            'nomor_paten' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|in:HKI,PATEN',
            'link_ebook' => 'nullable|url|max:255',
            'videos' => 'nullable|array',
            'videos.*.type' => 'required|in:youtube,mp4',
            'videos.*.path_youtube' => 'nullable|url|required_if:videos.*.type,youtube',
            'videos.*.path_mp4' => 'nullable|file|mimes:mp4|max:20480|required_if:videos.*.type,mp4', // max 20MB
        ]);

        DB::beginTransaction();
        try {
            $data = $request->except(['inovator', 'gambar', 'foto_poster', 'videos']);
            
            $data['inovator'] = implode(', ', $request->input('inovator'));

            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('produk_inovasi/gambar', 'public');
            }
            if ($request->hasFile('foto_poster')) {
                $data['foto_poster'] = $request->file('foto_poster')->store('produk_inovasi/poster', 'public');
            }

            try {
                $translationService = new TranslationService();
                $data['nama_produk_en'] = $translationService->translate($request->nama_produk);
                $data['inovator_en'] = $translationService->translate($data['inovator']);
                $data['deskripsi_en'] = $translationService->translateHtml($request->deskripsi);
            } catch (\Exception $e) {
                \Log::warning('Auto-translation failed during product creation: ' . $e->getMessage());
                $data['nama_produk_en'] = null;
                $data['inovator_en'] = null;
                $data['deskripsi_en'] = null;
            }

            $produk = ProdukInovasi::create($data);

            // Handle multiple videos
            if ($request->has('videos')) {
                foreach ($request->videos as $videoData) {
                    $videoPath = null;
                    if ($videoData['type'] === 'youtube') {
                        $videoPath = $videoData['path_youtube'];
                    } elseif ($videoData['type'] === 'mp4' && isset($videoData['path_mp4'])) {
                        $videoPath = $videoData['path_mp4']->store('produk_inovasi/video', 'public');
                    }

                    if ($videoPath) {
                        $produk->videos()->create([
                            'type' => $videoData['type'],
                            'path' => $videoPath,
                        ]);
                    }
                }
            }
            
            DB::commit();

            return redirect()->route($this->getRoutePrefix() . '.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk inovasi: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function getProdukDetail($id)
    {
        $produk = ProdukInovasi::with('videos')->findOrFail($id);
        return response()->json($produk);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'inovator' => 'required|array|min:1',
            'inovator.*' => 'required|string|max:255',
            'nomor_paten' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kategori' => 'required|in:HKI,PATEN',
            'link_ebook' => 'nullable|url|max:255',
            'videos' => 'nullable|array',
            'videos.*.id' => 'nullable|integer|exists:produk_inovasi_videos,id',
            'videos.*.type' => 'required|in:youtube,mp4',
            'videos.*.path_youtube' => 'nullable|url|required_if:videos.*.type,youtube',
            'videos.*.path_mp4' => 'nullable|file|mimes:mp4|max:20480', // max 20MB
        ]);

        DB::beginTransaction();
        try {
            $produk = ProdukInovasi::findOrFail($id);
            $data = $request->except(['inovator', 'gambar', 'foto_poster', 'videos', '_token', '_method']);
            
            $data['inovator'] = implode(', ', $request->input('inovator'));

            if ($request->hasFile('gambar')) {
                if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
                $data['gambar'] = $request->file('gambar')->store('produk_inovasi/gambar', 'public');
            }
            if ($request->hasFile('foto_poster')) {
                if ($produk->foto_poster) Storage::disk('public')->delete($produk->foto_poster);
                $data['foto_poster'] = $request->file('foto_poster')->store('produk_inovasi/poster', 'public');
            }

            // Handle video updates
            $submittedVideoIds = [];
            if ($request->has('videos')) {
                foreach ($request->videos as $videoData) {
                    $videoPath = null;
                    $isNewFile = false;

                    if ($videoData['type'] === 'youtube') {
                        $videoPath = $videoData['path_youtube'];
                    } elseif ($videoData['type'] === 'mp4' && isset($videoData['path_mp4'])) {
                        $videoPath = $videoData['path_mp4']->store('produk_inovasi/video', 'public');
                        $isNewFile = true;
                    }
                    
                    if (isset($videoData['id']) && !empty($videoData['id'])) {
                        // Update existing video
                        $video = ProdukInovasiVideo::findOrFail($videoData['id']);
                        $updateData = ['type' => $videoData['type']];
                        if ($videoPath) {
                            if ($isNewFile && $video->type === 'mp4' && $video->path) {
                                Storage::disk('public')->delete($video->path); // delete old mp4
                            }
                            $updateData['path'] = $videoPath;
                        }
                        $video->update($updateData);
                        $submittedVideoIds[] = $video->id;
                    } else {
                        // Create new video
                        if ($videoPath) {
                            $newVideo = $produk->videos()->create([
                                'type' => $videoData['type'],
                                'path' => $videoPath,
                            ]);
                            $submittedVideoIds[] = $newVideo->id;
                        }
                    }
                }
            }
            
            // Delete videos that were removed from the form
            $produk->videos()->whereNotIn('id', $submittedVideoIds)->get()->each->delete();

            try {
                $translationService = new TranslationService();
                if ($request->filled('nama_produk') && $request->nama_produk !== $produk->nama_produk) {
                    $data['nama_produk_en'] = $translationService->translate($request->nama_produk);
                }
                if (isset($data['inovator']) && $data['inovator'] !== $produk->inovator) {
                    $data['inovator_en'] = $translationService->translate($data['inovator']);
                }
                if ($request->filled('deskripsi') && $request->deskripsi !== $produk->deskripsi) {
                    $data['deskripsi_en'] = $translationService->translateHtml($request->deskripsi);
                }
            } catch (\Exception $e) {
                \Log::warning('Auto-translation failed during product update: ' . $e->getMessage());
            }
            
            $produk->update($data);

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Produk inovasi berhasil diperbarui!']);
            }

            return redirect()->route($this->getRoutePrefix() . '.produk_inovasi')->with('success', 'Produk inovasi berhasil diperbarui!');
        } catch (\Exception $e) {
             DB::rollBack();
             if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui: ' . $e->getMessage()]);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            // The deleting event on the ProdukInovasi model will handle deleting child videos & files.
            $produk = ProdukInovasi::findOrFail($id);

            if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
            if ($produk->foto_poster) Storage::disk('public')->delete($produk->foto_poster);

            $produk->delete();
            
            return redirect()->route($this->getRoutePrefix() . '.produk_inovasi')->with('success', 'Produk inovasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route($this->getRoutePrefix() . '.produk_inovasi')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $validator = \Validator::make($request->all(), ['upload' => 'required|image|mimes:jpeg,png,jpg|max:2048']);
            if ($validator->fails()) {
                return response()->json(['error' => ['message' => $validator->errors()->first('upload')]]);
            }
            $filePath = $request->file('upload')->store('produk_inovasi/editor', 'public');
            return response()->json(['url' => Storage::url($filePath)]);
        }
        return response()->json(['error' => ['message' => 'No file uploaded']]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ProdukInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Berita;
use App\Models\Video;
use App\Models\MitraKolaborasi;

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
        $produkInovasi = ProdukInovasi::all();
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
        $video = Video::first();
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
            'video_type' => 'nullable|in:youtube,mp4',
            'video_path_youtube' => 'nullable|url|required_if:video_type,youtube',
            'video_path_mp4' => 'nullable|file|mimes:mp4|max:20480|required_if:video_type,mp4', // max 20MB
        ]);

        try {
            $data = $request->except(['inovator', 'gambar', 'foto_poster', 'video_path_youtube', 'video_path_mp4']);
            
            // Handle multiple innovators
          $data['inovator'] = implode(', ', $request->input('inovator'));

            // Handle file uploads
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $request->file('gambar')->store('produk_inovasi/gambar', 'public');
            }
            if ($request->hasFile('foto_poster')) {
                $data['foto_poster'] = $request->file('foto_poster')->store('produk_inovasi/poster', 'public');
            }

            // Handle video
            if ($request->video_type === 'youtube') {
                $data['video_path'] = $request->video_path_youtube;
            } elseif ($request->video_type === 'mp4' && $request->hasFile('video_path_mp4')) {
                $data['video_path'] = $request->file('video_path_mp4')->store('produk_inovasi/video', 'public');
            }

            ProdukInovasi::create($data);

            return redirect()->route($this->getRoutePrefix() . '.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk inovasi: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function getProdukDetail($id)
    {
        $produk = ProdukInovasi::findOrFail($id);
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
            'video_type' => 'nullable|in:youtube,mp4',
            'video_path_youtube' => 'nullable|url|required_if:video_type,youtube',
            'video_path_mp4' => 'nullable|file|mimes:mp4|max:20480', // max 20MB
        ]);

        try {
            $produk = ProdukInovasi::findOrFail($id);
            $data = $request->except(['inovator', 'gambar', 'foto_poster', 'video_path_youtube', 'video_path_mp4', '_token', '_method']);
            
          $data['inovator'] = implode(', ', $request->input('inovator'));

            // Handle file updates
            if ($request->hasFile('gambar')) {
                if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
                $data['gambar'] = $request->file('gambar')->store('produk_inovasi/gambar', 'public');
            }
            if ($request->hasFile('foto_poster')) {
                if ($produk->foto_poster) Storage::disk('public')->delete($produk->foto_poster);
                $data['foto_poster'] = $request->file('foto_poster')->store('produk_inovasi/poster', 'public');
            }

            // Handle video update
            if ($request->video_type === 'youtube') {
                if ($produk->video_type === 'mp4' && $produk->video_path) Storage::disk('public')->delete($produk->video_path);
                $data['video_path'] = $request->video_path_youtube;
            } elseif ($request->video_type === 'mp4' && $request->hasFile('video_path_mp4')) {
                if ($produk->video_path) Storage::disk('public')->delete($produk->video_path);
                $data['video_path'] = $request->file('video_path_mp4')->store('produk_inovasi/video', 'public');
            } elseif (empty($request->video_type)) {
                 if ($produk->video_path) Storage::disk('public')->delete($produk->video_path);
                 $data['video_type'] = null;
                 $data['video_path'] = null;
            }

            $produk->update($data);

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Produk inovasi berhasil diperbarui!']);
            }

            return redirect()->route($this->getRoutePrefix() . '.produk_inovasi')->with('success', 'Produk inovasi berhasil diperbarui!');
        } catch (\Exception $e) {
             if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui: ' . $e->getMessage()]);
            }
            return redirect()->back()->with('error', 'Gagal memperbarui: ' . $e->getMessage())->withInput();
        }
    }
    
    public function destroy($id)
    {
        try {
            $produk = ProdukInovasi::findOrFail($id);

            // Delete associated files
            if ($produk->gambar) Storage::disk('public')->delete($produk->gambar);
            if ($produk->foto_poster) Storage::disk('public')->delete($produk->foto_poster);
            if ($produk->video_type === 'mp4' && $produk->video_path) Storage::disk('public')->delete($produk->video_path);

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
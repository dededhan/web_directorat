<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\ProdukInovasi;
use App\Models\ProgramLayanan;
use App\Models\Dokumen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Perform global search across multiple content types
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $results = [];
        
        // Trim and validate query
        $query = trim($query);
        
        if (strlen($query) < 2) {
            return view('search.SearchBarResult', [
                'query' => $query,
                'results' => [],
                'message' => __('Silakan masukkan minimal 2 karakter untuk pencarian.')
            ]);
        }
        
        // Search in Berita
        $berita = Berita::where('judul_berita', 'like', "%{$query}%")
            ->orWhere('isi_berita', 'like', "%{$query}%")
            ->orWhere('judul_en', 'like', "%{$query}%")
            ->orWhere('isi_en', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Berita',
                    'type_icon' => '📰',
                    'title' => $item->getTranslatedTitle(),
                    'description' => mb_substr(strip_tags($item->getTranslatedContent()), 0, 150) . '...',
                    'image' => asset('storage/' . $item->gambar),
                    'url' => route('Berita.show', $item->slug),
                    'created_at' => Carbon::parse($item->tanggal),
                ];
            });
        
        // Search in ProdukInovasi
        $produkInovasi = ProdukInovasi::where('nama_produk', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->orWhere('nama_produk_en', 'like', "%{$query}%")
            ->orWhere('deskripsi_en', 'like', "%{$query}%")
            ->orWhere('inovator', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Produk Inovasi',
                    'type_icon' => '💡',
                    'title' => $item->getTranslatedName(),
                    'description' => mb_substr(strip_tags($item->deskripsi ?? ''), 0, 150) . '...',
                    'image' => asset('storage/' . $item->gambar),
                    'url' => route('subdirektorat-inovasi.riset_unj.produk_inovasi.show', $item->id),
                    'created_at' => $item->created_at,
                ];
            });
        
        // Search in ProgramLayanan
        $programLayanan = ProgramLayanan::where('judul', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->orWhere('judul_en', 'like', "%{$query}%")
            ->orWhere('deskripsi_en', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($item) {
                // Use the URL field if available, otherwise link to program-layanan page
                $url = $item->url ?? route('program-layanan');
                
                return [
                    'type' => 'Program dan Layanan',
                    'type_icon' => '🎯',
                    'title' => $item->getTranslatedTitle(),
                    'description' => mb_substr(strip_tags($item->getTranslatedDescription() ?? ''), 0, 150) . '...',
                    'image' => asset('storage/' . $item->image),
                    'url' => $url,
                    'created_at' => $item->created_at,
                ];
            });

        // Search in Dokumen
        $dokumen = Dokumen::where('judul_dokumen', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->orWhere('nama_file', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'Dokumen',
                    'type_icon' => '📄',
                    'title' => $item->judul_dokumen,
                    'description' => mb_substr(strip_tags($item->deskripsi ?? ''), 0, 150) . '...'. ($item->nama_file ? ' ['.$item->nama_file.']' : ''),
                    'image' => null,
                    'url' => route('documents.preview', $item->id),
                    'created_at' => Carbon::parse($item->tanggal_publikasi),
                ];
            });
        
        // Merge all results and sort by type
        $results = collect()
            ->merge($berita)
            ->merge($produkInovasi)
            ->merge($dokumen)
            ->merge($programLayanan);
        
        return view('search.SearchBarResult', [
            'query' => $query,
            'results' => $results,
            'message' => $results->isEmpty() ? __('Tidak ada hasil yang ditemukan untuk pencarian Anda.') : null
        ]);
    }

    /**
     * API endpoint untuk auto-complete search
     */
    public function autocomplete(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        
        // Get suggestions from Berita
        $berita = Berita::where('judul_berita', 'like', "%{$query}%")
            ->select('judul_berita as title')
            ->limit(5)
            ->get();
        
        // Get suggestions from ProdukInovasi
        $produk = ProdukInovasi::where('nama_produk', 'like', "%{$query}%")
            ->select('nama_produk as title')
            ->limit(5)
            ->get();
        
        // Get suggestions from ProgramLayanan
        $program = ProgramLayanan::where('judul', 'like', "%{$query}%")
            ->select('judul as title')
            ->limit(5)
            ->get();

        // Get suggestions from Dokumen
        $dokumen = Dokumen::where('judul_dokumen', 'like', "%{$query}%")
            ->orWhere('deskripsi', 'like', "%{$query}%")
            ->orWhere('nama_file', 'like', "%{$query}%")
            ->select('judul_dokumen as title')
            ->limit(5)
            ->get();
        
        $suggestions = collect()
            ->merge($berita)
            ->merge($produk)
            ->merge($program)
            ->merge($dokumen)
            ->unique('title')
            ->values()
            ->take(10);
        
        return response()->json($suggestions);
    }
}

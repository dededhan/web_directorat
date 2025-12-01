<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasRoleBasedViews;
use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Mews\Purifier\Facades\Purifier;

class RankingController extends Controller
{
    use HasRoleBasedViews;

    /**
     * Display a listing of rankings with filters and search
     */
    public function index(Request $request)
    {
        $query = Ranking::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Score filter
        if ($request->filled('has_score')) {
            if ($request->has_score === '1') {
                $query->whereNotNull('score_ranking')->where('score_ranking', '!=', '');
            } elseif ($request->has_score === '0') {
                $query->where(function($q) {
                    $q->whereNull('score_ranking')->orWhere('score_ranking', '');
                });
            }
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title_asc':
                $query->orderBy('judul', 'asc');
                break;
            case 'title_desc':
                $query->orderBy('judul', 'desc');
                break;
            default: // newest
                $query->latest();
                break;
        }

        $rankings = $query->paginate(20);

        return view($this->resolveViewByRole('ranking.index'), compact('rankings'));
    }

    /**
     * Show the form for creating a new ranking
     */
    public function create()
    {
        return view($this->resolveViewByRole('ranking.create'));
    }


    /**
     * Store a newly created ranking in storage
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'score_ranking' => 'nullable|string|max:50',
                'deskripsi' => 'required|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if (!$request->hasFile('gambar')) {
                return redirect()->back()
                    ->with('error', 'Upload gambar gagal. Pastikan file gambar valid.')
                    ->withInput();
            }

            // Sanitize HTML content
            $cleanDeskripsi = Purifier::clean($validated['deskripsi']);

            // Store image
            $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
            $gambarPath = $request->file('gambar')->storeAs('ranking-images', $namaFile, 'public');

            // Create ranking
            Ranking::create([
                'judul' => $validated['judul'],
                'score_ranking' => $validated['score_ranking'],
                'deskripsi' => $cleanDeskripsi,
                'gambar' => $gambarPath,
                'slug' => Str::slug($validated['judul'])
            ]);

            return redirect()
                ->route($this->resolveRedirectByRole('ranking.index'))
                ->with('success', 'Ranking berhasil disimpan!');

        } catch (\Exception $e) {
            Log::error('Error storing ranking: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan ranking: ' . $e->getMessage())
                ->withInput();
        }
    }


    /**
     * Display the specified ranking (public view)
     */
    public function show(string $slug)
    {
        $ranking = Ranking::where('slug', $slug)->firstOrFail();
        return view('pemeringkatan.ranking-unj.detail', compact('ranking'));
    }

    /**
     * Show the form for editing the specified ranking
     */
    public function edit(Ranking $ranking) 
    {
        return view($this->resolveViewByRole('ranking.edit'), compact('ranking'));
    }

    /**
     * Get ranking detail (AJAX endpoint - legacy, kept for compatibility)
     */
    public function getRankingDetail($id)
    {
        $ranking = Ranking::findOrFail($id);
        return response()->json($ranking);
    }

    /**
     * Update the specified ranking in storage
     */
    public function update(Request $request, string $id) 
    {
        try {
            $ranking = Ranking::findOrFail($id);
            
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'score_ranking' => 'nullable|string|max:50',
                'deskripsi' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Sanitize HTML content
            $cleanDeskripsi = Purifier::clean($validated['deskripsi']);

            // Update basic fields
            $ranking->judul = $validated['judul'];
            $ranking->score_ranking = $validated['score_ranking'];
            $ranking->deskripsi = $cleanDeskripsi;
            $ranking->slug = Str::slug($validated['judul']);

            // Handle image upload if new image provided
            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                // Delete old image
                if ($ranking->gambar && Storage::disk('public')->exists($ranking->gambar)) {
                    Storage::disk('public')->delete($ranking->gambar);
                }
                
                // Store new image
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs('ranking-images', $namaFile, 'public');
                $ranking->gambar = $gambarPath;
            }

            $ranking->save();

            return redirect()
                ->route($this->resolveRedirectByRole('ranking.index'))
                ->with('success', 'Ranking berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating ranking: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memperbarui ranking: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified ranking from storage
     */
    public function destroy(string $id)
    {
        try {
            $ranking = Ranking::findOrFail($id);
            
            // Delete associated image
            if ($ranking->gambar && Storage::disk('public')->exists($ranking->gambar)) {
                Storage::disk('public')->delete($ranking->gambar);
            }
            
            $ranking->delete();

            return redirect()
                ->route($this->resolveRedirectByRole('ranking.index'))
                ->with('success', 'Ranking berhasil dihapus!');
                
        } catch (\Exception $e) {
            Log::error('Error deleting ranking: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus ranking: ' . $e->getMessage());
        }
    }

    /**
     * Handle CKEditor image upload
     */
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $path = $request->file('upload')->store('ranking-images', 'public'); 
        $url = Storage::url($path);
        
        return response()->json([
            'url' => asset($url),
        ]);
    }

    /**
     * Display all rankings (public view)
     */
    public function showAllRankings()
    {
        $rankings = Ranking::all();
        return view('pemeringkatan.ranking-unj.index', compact('rankings'));
    }
}
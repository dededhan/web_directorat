<?php

namespace App\Http\Controllers;

use App\Models\Ranking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; // Import Log facade

class RankingController extends Controller
{

    private function getRoutePrefix()
    {
        $role = auth()->user()->role;
        if ($role === 'admin_direktorat') {
            return 'admin';
        } else if ($role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }
        // Default or fallback prefix if needed
        return 'admin';
    }


    public function index()
    {
        $rankings = Ranking::latest()->get();
        $routePrefix = $this->getRoutePrefix();

        if (auth()->user()->role === 'admin_direktorat') {
             return view('admin.ranking_dashboard', compact('rankings', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
             return view('admin_pemeringkatan.ranking_dashboard', compact('rankings', 'routePrefix'));
        }
        return view('admin.ranking_dashboard', compact('rankings', 'routePrefix')); // Or redirect, or abort
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'score_ranking' => 'nullable|string|max:50',
                'deskripsi' => 'required|string',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'ranking-images',
                    $namaFile,
                    'public'
                );
                Ranking::create([
                    'judul' => $request->judul,
                    'score_ranking' => $request->score_ranking,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => $gambarPath,
                    'slug' => Str::slug($request->judul)
                ]);
                $routePrefix = $this->getRoutePrefix();
                return redirect()->route($routePrefix . '.ranking.index')
                    ->with('success', 'Ranking berhasil disimpan!');
            } else {
                return redirect()->back()
                    ->with('error', 'Upload gambar gagal. Pastikan file gambar valid.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            Log::error('Error storing ranking: ' . $e->getMessage()); // Use Log facade
            return redirect()->back()
                ->with('error', 'Gagal menambahkan ranking: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function show(string $slug)
    {
        $ranking = Ranking::where('slug', $slug)->firstOrFail();
        return view('Pemeringkatan.ranking_unj.ranking_detail', compact('ranking'));
    }


    // New edit method
    public function edit(Ranking $ranking) 
    {
        $routePrefix = $this->getRoutePrefix();
        $viewPath = $routePrefix . '.ranking_edit';
        if (!view()->exists($viewPath)) {
            $viewPath = 'admin.ranking_edit';
            if (!view()->exists($viewPath)) {
                 abort(404, "Edit view for ranking not found.");
            }
        }
        return view($viewPath, compact('ranking', 'routePrefix'));
    }


    public function getRankingDetail($id)
    {
        $ranking = Ranking::findOrFail($id);
        return response()->json($ranking);
    }

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

            $ranking->judul = $validated['judul'];
            $ranking->score_ranking = $validated['score_ranking'];
            $ranking->deskripsi = $validated['deskripsi'];
            $ranking->slug = Str::slug($validated['judul']);

            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                // Delete old image if it exists
                if ($ranking->gambar && Storage::disk('public')->exists($ranking->gambar)) {
                    Storage::disk('public')->delete($ranking->gambar);
                }
                // Store new image
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'ranking-images',
                    $namaFile,
                    'public'
                );
                $ranking->gambar = $gambarPath;
            }

            $ranking->save();
            $routePrefix = $this->getRoutePrefix();

            // Removed AJAX check as form submission will be standard
            return redirect()->route($routePrefix . '.ranking.index')
                ->with('success', 'Ranking berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating ranking: ' . $e->getMessage()); // Use Log facade
            // Removed AJAX check
            return redirect()->back()
                ->with('error', 'Gagal memperbarui ranking: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $ranking = Ranking::findOrFail($id);
            if ($ranking->gambar && Storage::disk('public')->exists($ranking->gambar)) {
                Storage::disk('public')->delete($ranking->gambar);
            }
            $ranking->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.ranking.index')
                ->with('success', 'Ranking berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting ranking: ' . $e->getMessage()); // Use Log facade
            return redirect()->back()
                ->with('error', 'Gagal menghapus ranking: ' . $e->getMessage());
        }
    }


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

    public function showAllRankings()
    {
        $rankings = Ranking::all();
        return view('Pemeringkatan.ranking_unj.rankingunj', compact('rankings'));
    }
}
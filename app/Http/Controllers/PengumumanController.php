<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

use Illuminate\Http\Request;
use App\Http\Requests\StorePengumumanRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class PengumumanController extends Controller
{
    /**
     * Get the correct route name prefix based on authenticated user role
     */
    private function getRoutePrefix()
    {
        if (auth()->user()->hasRole('admin_direktorat')) {
            return 'admin';
        } else if (auth()->user()->hasRole('admin_hilirisasi')) {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        } else if (auth()->user()->hasRole('admin_inovasi')) {
            return 'subdirektorat-inovasi.admin_inovasi';
        } else if (auth()->user()->hasRole('admin_pemeringkatan')) {
            return 'admin_pemeringkatan';
        } 
        
        return 'admin';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumumans = Pengumuman::all();
        $routePrefix = $this->getRoutePrefix();
        
        if (auth()->user()->hasRole('admin_direktorat')) {
            return view('admin.newsscroll', compact('pengumumans', 'routePrefix'));
        } elseif (auth()->user()->hasRole('admin_hilirisasi')) {
            return view('subdirektorat-inovasi.admin_hilirisasi.newsscroll', compact('pengumumans', 'routePrefix'));
        } elseif (auth()->user()->hasRole('admin_inovasi')) {
            return view('subdirektorat-inovasi.admin_inovasi.newsscroll', compact('pengumumans', 'routePrefix'));
        } elseif (auth()->user()->hasRole('admin_pemeringkatan')) {
            return view('admin_pemeringkatan.newsscroll', compact('pengumumans', 'routePrefix'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getPengumumanDetail($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return response()->json($pengumuman);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePengumumanRequest $request)
    {
        try {
            $data = $request->validated();
            $data['status'] = true;

            // Debug data sebelum disimpan
            logger()->info('Data to save:', $data);

            Pengumuman::create($data);

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.news-scroll.index')
                ->with('success', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            // Log error
            logger()->error('Error saving data: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan data!');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        //
    }

    public function update(Request $request, Pengumuman $news_scroll)
    {
        try {
            $validated = $request->validate([
                'judul_pengumuman' => 'required|string|max:50',
                'icon' => 'nullable|string',
                'isi_pengumuman' => 'required|string|max:200',
                'status' => 'sometimes|boolean'
            ]);

            $news_scroll->update($validated);

            $routePrefix = $this->getRoutePrefix();
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Pengumuman berhasil diperbarui!']);
            }

            return redirect()->route($routePrefix . '.news-scroll.index')
                ->with('success', 'Pengumuman berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating pengumuman: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui pengumuman: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengumuman: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $news_scroll)
    {
        try {
            $news_scroll->delete();
            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.news-scroll.index')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting: ' . $e->getMessage());
            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.news-scroll.index')->with('error', 'Gagal menghapus data!');
        }
    }

    public function getActiveAnnouncements()
    {
        $announcements = Pengumuman::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($announcements);
    }
}
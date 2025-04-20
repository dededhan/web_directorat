<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Youtube;


class YoutubeController extends Controller
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
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }
        
        return 'admin';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Youtube::latest()->get();
        $routePrefix = $this->getRoutePrefix();
        
        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.youtube', compact('videos', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return view('subdirektorat-inovasi.admin_hilirisasi.youtube', compact('videos', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.youtube', compact('videos', 'routePrefix'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'link' => 'required|url'
        ], [
            'judul.required' => 'Judul video wajib diisi',
            'judul.max' => 'Judul tidak boleh lebih dari 100 karakter',
            'deskripsi.required' => 'Deskripsi video wajib diisi',
            'link.required' => 'Link YouTube wajib diisi',
            'link.url' => 'Format link YouTube tidak valid'
        ]);

        Youtube::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'link' => $request->link
        ]);

        $routePrefix = $this->getRoutePrefix();
        return redirect()->route($routePrefix . '.youtube.index')
            ->with('success', 'Video berhasil ditambahkan!');
    }


    public function getVideoDetail($id)
    {
        $video = Youtube::findOrFail($id);
        return response()->json($video);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $video = Youtube::findOrFail($id);
            
            $validated = $request->validate([
                'judul' => 'required|string|max:100',
                'deskripsi' => 'required|string',
                'link' => 'required|url'
            ], [
                'judul.required' => 'Judul video wajib diisi',
                'judul.max' => 'Judul tidak boleh lebih dari 100 karakter',
                'deskripsi.required' => 'Deskripsi video wajib diisi',
                'link.required' => 'Link YouTube wajib diisi',
                'link.url' => 'Format link YouTube tidak valid'
            ]);

            $video->update([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'link' => $validated['link']
            ]);

            $routePrefix = $this->getRoutePrefix();
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Video berhasil diperbarui!']);
            }

            return redirect()->route($routePrefix . '.youtube.index')
                ->with('success', 'Video berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating video: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui video: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui video: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $video = Youtube::findOrFail($id);
            $video->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.youtube.index')
                ->with('success', 'Video berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting video: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus video: ' . $e->getMessage());
        }
    }

    /**
     * Display a preview of the video.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function preview($id)
    {
        $video = Youtube::findOrFail($id);
        $routePrefix = $this->getRoutePrefix();
        return view($routePrefix . '.youtube-preview', compact('video', 'routePrefix'));
    }

    /**
     * Get latest YouTube videos for the homepage.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFrontendVideos()
    {
        // Get the latest 3 YouTube videos
        $videos = Youtube::latest()->take(3)->get();
        return response()->json($videos);
    }
}
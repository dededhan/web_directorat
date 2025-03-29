<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Youtube;

class YoutubeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Youtube::latest()->get();
        return view('admin.youtube', compact('videos'));
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

        return redirect()->route('admin.youtube.index')
            ->with('success', 'Video berhasil ditambahkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = Youtube::findOrFail($id);
        $video->delete();

        return redirect()->route('admin.youtube.index')
            ->with('success', 'Video berhasil dihapus!');
    }
}
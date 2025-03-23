<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBeritaRequest;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $beritas = Berita::latest()->get();
        return view('admin.newsadmin', compact('beritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeritaRequest $request)
    {
        // $gambarPath = $request->file('gambar')->store('berita-images', 'public');
        
        // Generate nama file unik
        $namaFile = time() . '_' . $request->file('gambar')->getClientOriginalName();
        $gambarPath = $request->file('gambar')->storeAs(
            'berita-images', 
            $namaFile,
            'public'
        );

        Berita::create([
            'kategori' => $request->kategori,
            'tanggal' => $request->tanggal,
            'judul' => $request->judul_berita,
            'isi' => $request->isi_berita,
            'gambar' => $gambarPath
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

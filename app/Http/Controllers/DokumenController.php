<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDokumenRequest;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumens = Dokumen::orderBy('tanggal_publikasi', 'desc')->get();
        return view('admin.document', compact('dokumens'));
    }
    public function create()
    {
        //
    }

    public function store(StoreDokumenRequest $request)
    {
        $file = $request->file('file_dokumen');
        $originalName = $file->getClientOriginalName();
        $hashName = $file->hashName();
        $path = $file->store('dokumen', 'public'); 
        
        Dokumen::create([
            'kategori' => $request->kategori,
            'tanggal_publikasi' => $request->tanggal,
            'judul_dokumen' => $request->judul_dokumen,
            'deskripsi' => $request->deskripsi,
            'nama_file' => $file->getClientOriginalName(),
            'nama_file_hash' => $file->hashName(),
            'path' => $path, // Contoh path: "dokumen/filename.pdf"
            'ukuran' => $file->getSize(),
            'ekstensi' => $file->getClientOriginalExtension()
        ]);
    
        return redirect()->back()->with('success', 'Dokumen berhasil disimpan');

    }

    public function download(Dokumen $dokumen)
    {
        // Pastikan file ada sebelum didownload
        if (!Storage::disk('public')->exists($dokumen->path)) {
            abort(404);
        }
        
        return Storage::disk('public')->download($dokumen->path, $dokumen->nama_file);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokumen $dokumen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokumen $dokumen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokumen $dokumen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $dokumen)
    {
        try {
            // Pastikan path ada sebelum menghapus
            if ($dokumen->path && Storage::exists($dokumen->path)) {
                Storage::delete($dokumen->path);
            }
            
            $dokumen->delete();
            return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }
}

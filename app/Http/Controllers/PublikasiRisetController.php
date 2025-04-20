<?php

namespace App\Http\Controllers;

use App\Models\PublikasiRiset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublikasiRisetController extends Controller
{
    private function getRoutePrefix()
    {
        if (auth()->user()->role === 'admin_direktorat') {
            return 'admin';
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        } else if (auth()->user()->role === 'admin_inovasi') {
            return 'subdirektorat-inovasi.admin_inovasi';
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }
        
        return 'admin';
    }
    public function index()
    {
        $publikasiRiset = PublikasiRiset::orderBy('tanggal_publikasi', 'desc')->get();
        $routePrefix = $this->getRoutePrefix();
        
        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.SDGs.publikasi_riset', compact('publikasiRiset', 'routePrefix'));}
      
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_dokumen' => 'nullable|file|mimes:pdf,docx,doc|max:10240',
            'kategori' => 'nullable|string',
            'tanggal_publikasi' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['judul', 'penulis', 'deskripsi', 'kategori', 'tanggal_publikasi']);

        // Handle gambar upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('publikasi-riset/gambar', 'public');
            $data['gambar_path'] = $gambarPath;
            $data['gambar_nama'] = $gambar->getClientOriginalName();
        }

        // Handle file dokumen upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filePath = $file->store('publikasi-riset/dokumen', 'public');
            $data['file_path'] = $filePath;
            $data['file_nama'] = $file->getClientOriginalName();
        }

        PublikasiRiset::create($data);

        return redirect()->back()->with('success', 'Publikasi/Riset berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $publikasiRiset = PublikasiRiset::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'file_dokumen' => 'nullable|file|mimes:pdf,docx,doc|max:10240',
            'kategori' => 'nullable|string',
            'tanggal_publikasi' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->only(['judul', 'penulis', 'deskripsi', 'kategori', 'tanggal_publikasi']);

        // Handle gambar update
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($publikasiRiset->gambar_path && Storage::disk('public')->exists($publikasiRiset->gambar_path)) {
                Storage::disk('public')->delete($publikasiRiset->gambar_path);
            }

            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('publikasi-riset/gambar', 'public');
            $data['gambar_path'] = $gambarPath;
            $data['gambar_nama'] = $gambar->getClientOriginalName();
        }

        // Handle file dokumen update
        if ($request->hasFile('file_dokumen')) {
            // Delete old file if exists
            if ($publikasiRiset->file_path && Storage::disk('public')->exists($publikasiRiset->file_path)) {
                Storage::disk('public')->delete($publikasiRiset->file_path);
            }

            $file = $request->file('file_dokumen');
            $filePath = $file->store('publikasi-riset/dokumen', 'public');
            $data['file_path'] = $filePath;
            $data['file_nama'] = $file->getClientOriginalName();
        }

        $publikasiRiset->update($data);

        return redirect()->back()->with('success', 'Publikasi/Riset berhasil diperbarui');
    }

    public function destroy($id)
    {
        $publikasiRiset = PublikasiRiset::findOrFail($id);

        // Delete image if exists
        if ($publikasiRiset->gambar_path && Storage::disk('public')->exists($publikasiRiset->gambar_path)) {
            Storage::disk('public')->delete($publikasiRiset->gambar_path);
        }

        // Delete file if exists
        if ($publikasiRiset->file_path && Storage::disk('public')->exists($publikasiRiset->file_path)) {
            Storage::disk('public')->delete($publikasiRiset->file_path);
        }

        $publikasiRiset->delete();

        return redirect()->back()->with('success', 'Publikasi/Riset berhasil dihapus');
    }

    public function download($id)
    {
        $publikasiRiset = PublikasiRiset::findOrFail($id);
        
        if (!$publikasiRiset->file_path || !Storage::disk('public')->exists($publikasiRiset->file_path)) {
            abort(404, 'File not found');
        }
        
        return Storage::disk('public')->download($publikasiRiset->file_path, $publikasiRiset->file_nama);
    }
}
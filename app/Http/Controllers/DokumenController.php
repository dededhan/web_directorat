<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDokumenRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class DokumenController extends Controller
{
    /**
     * Display a listing of the documents in admin panel.
     */
    public function index()
    {
        $dokumens = Dokumen::orderBy('tanggal_publikasi', 'desc')->get();
        if (auth()->user()->hasRole('admin_direktorat')) {
            return view('admin.document', compact('dokumens'));
        } elseif (auth()->user()->hasRole('admin_hilirisasi')) {
            return view('subdirektorat-inovasi.admin_hilirisasi.document', compact('dokumens'));
        }
    }

    /**
     * Display the document page for public users
     */
    public function publicIndex()
    {
        return view('document.document');
    }

    /**
     * API endpoint to get all documents for the frontend
     */
    public function apiGetDocuments()
    {
        $dokumens = Dokumen::orderBy('tanggal_publikasi', 'desc')->get();
        return response()->json($dokumens);
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(StoreDokumenRequest $request)
    {
        $file = $request->file('file_dokumen');
        $path = $file->store('dokumen', 'public'); 
        
        Dokumen::create([
            'kategori' => $request->kategori,
            'tanggal_publikasi' => $request->tanggal,
            'judul_dokumen' => $request->judul_dokumen,
            'deskripsi' => $request->deskripsi,
            'nama_file' => $file->getClientOriginalName(),
            'nama_file_hash' => $file->hashName(),
            'path' => $path,
            'ukuran' => $file->getSize(),
            'ekstensi' => $file->getClientOriginalExtension()
        ]);
    
        return redirect()->back()->with('success', 'Dokumen berhasil disimpan');
    }

    /**
     * Download a document file.
     */
    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        // Pastikan file ada sebelum didownload
        if (!Storage::disk('public')->exists($dokumen->path)) {
            abort(404, 'File not found');
        }
        
        return Storage::disk('public')->download($dokumen->path, $dokumen->nama_file);
    }

    /**
     * Preview a document file.
     */
    public function preview($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        // Pastikan file ada
        if (!Storage::disk('public')->exists($dokumen->path)) {
            abort(404, 'File not found');
        }
        
        $type = Storage::disk('public')->mimeType($dokumen->path);
        
        // For PDF files, display directly
        if ($type === 'application/pdf') {
            $file = Storage::disk('public')->get($dokumen->path);
            $response = Response::make($file, 200);
            $response->header('Content-Type', $type);
            return $response;
        }
        
        // For Word documents, use Google Drive Viewer
        if ($type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || 
            $type === 'application/msword') {
            
            // Create a publicly accessible URL to the document
            $publicUrl = URL::to(Storage::url($dokumen->path));
            
            // Use Google Drive Viewer
            $viewerUrl = 'https://docs.google.com/viewer?url=' . urlencode($publicUrl) . '&embedded=true';
            
            return view('document.google_drive_preview', [
                'document' => $dokumen,
                'viewerUrl' => $viewerUrl,
                'fileSize' => $this->formatFileSize($dokumen->ukuran),
                'uploadDate' => \Carbon\Carbon::parse($dokumen->tanggal_publikasi)->format('d M Y'),
                'extension' => strtoupper($dokumen->ekstensi ?: pathinfo($dokumen->nama_file, PATHINFO_EXTENSION))
            ]);
        }
        
        // Fallback to download for other types
        return redirect()->route('documents.download', $dokumen->id);
    }
    
    /**
     * Format file size for display
     */
    private function formatFileSize($bytes)
    {
        if ($bytes >= 1000000) {
            return number_format($bytes / 1048576, 1) . ' MB';
        }
        return number_format($bytes / 1024, 0) . ' KB';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokumen $document)
    {
        try {
            // Hapus file dari storage
            if ($document->path && Storage::disk('public')->exists($document->path)) {
                Storage::disk('public')->delete($document->path);
            }
            
            // Hapus record dari database
            $document->delete();
            
            return redirect()->back()->with('success', 'Dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

}
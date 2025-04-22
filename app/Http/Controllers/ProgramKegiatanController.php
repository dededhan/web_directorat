<?php

namespace App\Http\Controllers;

use App\Models\ProgramKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProgramKegiatanController extends Controller
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
    /**
     * Display a listing of the program kegiatan in admin panel.
     */
    public function index()
    {
        $programKegiatans = ProgramKegiatan::orderBy('tanggal', 'desc')->get();

        $routePrefix = $this->getRoutePrefix();
        
        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.SDGs.program_kegiatan', compact('programKegiatans', 'routePrefix'));
        }
    }

    /**
     * Store a newly created program kegiatan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:penelitian,pengabdian_masyarakat,pendidikan,kolaborasi',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $file = $request->file('gambar');
        $path = $file->store('program-kegiatan', 'public'); 
        
        ProgramKegiatan::create([
            'judul' => $request->judul,
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'nama_gambar' => $file->getClientOriginalName(),
            'nama_gambar_hash' => $file->hashName(),
            'path_gambar' => $path,
            'ukuran_gambar' => $file->getSize(),
            'ekstensi_gambar' => $file->getClientOriginalExtension()
        ]);
    
        return redirect()->back()->with('success', 'Program & Kegiatan berhasil disimpan');
    }

    /**
     * Get program details for editing.
     */
    public function detail($id)
    {
        $programKegiatan = ProgramKegiatan::findOrFail($id);
        return response()->json($programKegiatan);
    }

    /**
     * Update the specified program kegiatan in storage.
     */
    public function update(Request $request, ProgramKegiatan $programKegiatan)
    {
        $request->validate([
            'judul' => 'required|string|max:200',
            'tanggal' => 'required|date',
            'kategori' => 'required|in:penelitian,pengabdian_masyarakat,pendidikan,kolaborasi',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only(['judul', 'tanggal', 'kategori', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            // Delete old file
            if (Storage::disk('public')->exists($programKegiatan->path_gambar)) {
                Storage::disk('public')->delete($programKegiatan->path_gambar);
            }
            
            // Store new file
            $file = $request->file('gambar');
            $path = $file->store('program-kegiatan', 'public');
            
            $data = array_merge($data, [
                'nama_gambar' => $file->getClientOriginalName(),
                'nama_gambar_hash' => $file->hashName(),
                'path_gambar' => $path,
                'ukuran_gambar' => $file->getSize(),
                'ekstensi_gambar' => $file->getClientOriginalExtension()
            ]);
        }

        $programKegiatan->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Program & Kegiatan berhasil diperbarui'
            ]);
        }

        return redirect()->back()->with('success', 'Program & Kegiatan berhasil diperbarui');
    }

    /**
     * Remove the specified program kegiatan from storage.
     */
    public function destroy(ProgramKegiatan $programKegiatan)
    {
        try {
            // Delete image file
            if ($programKegiatan->path_gambar && Storage::disk('public')->exists($programKegiatan->path_gambar)) {
                Storage::disk('public')->delete($programKegiatan->path_gambar);
            }
            
            // Delete record
            $programKegiatan->delete();
            
            return redirect()->back()->with('success', 'Program & Kegiatan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Program & Kegiatan: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint to get program data for SDG Center page.
     */
    public function getSDGCenterPrograms()
    {
        $categories = ['penelitian', 'pengabdian_masyarakat', 'pendidikan', 'kolaborasi'];
        $programData = [];
        
        foreach ($categories as $category) {
            $programData[$category] = ProgramKegiatan::where('kategori', $category)
                ->latest()
                ->take(3)
                ->get()
                ->map(function($program) {
                    return [
                        'image' => asset('storage/' . $program->path_gambar),
                        'date' => $program->tanggal->format('F Y'),
                        'title' => $program->judul,
                        'description' => strip_tags(substr($program->deskripsi, 0, 150)) . '...'
                    ];
                });
        }
        
        return response()->json($programData);
    }
}
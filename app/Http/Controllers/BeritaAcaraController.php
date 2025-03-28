<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeritaAcara;
use App\Models\Katsinov;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BeritaAcaraController extends Controller
{
    public function index(Request $request)
    {
        $katsinov_id = $request->query('katsinov_id');
        $katsinov = null;
        
        if ($katsinov_id) {
            $katsinov = Katsinov::find($katsinov_id);
            if (!$katsinov) {
                return redirect()->back()->with('error', 'Katsinov data not found');
            }
            
            // Filter berita acara by katsinov_id if provided
            $beritaAcaras = BeritaAcara::where('katsinov_id', $katsinov_id)->get();
        } else {
            // Get all berita acara if no katsinov_id is provided
            $beritaAcaras = BeritaAcara::all();
        }

        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.formberitaacara';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.formberitaacara';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.formberitaacara';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.formberitaacara';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.formberitaacara';
        }

        return view($view, compact('beritaAcaras', 'katsinov'));
    }

    public function create(Request $request)
    {
        $katsinov_id = $request->query('katsinov_id');
        $katsinov = null;
        
        if ($katsinov_id) {
            $katsinov = Katsinov::find($katsinov_id);
            if (!$katsinov) {
                return redirect()->back()->with('error', 'Katsinov data not found');
            }
        }
        
        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.formberitaacara';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.formberitaacara';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.formberitaacara';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.formberitaacara';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.formberitaacara';
        }

        return view($view, compact('katsinov'));
    }

    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'judul_inovasi' => 'required|string|max:255',
                'jenis_inovasi' => 'required|string|max:255',
                'nilai_tki' => 'required|string|max:255',
                'opini_penilai' => 'required|string',
                'tanggal' => 'required|date',
                'tempat' => 'required|string|max:255',
                'surat_keputusan' => 'required|string|max:255',
                'hari' => 'required|string|max:255',
                'tanggal_numeric' => 'required|string|max:255',
                'bulan' => 'required|string|max:255',
                'tahun' => 'required|string|max:255',
                'penanggungjawab_nama' => 'required|string|max:255',
                'ketua_tim_nama' => 'required|string|max:255',
                'anggota1_nama' => 'required|string|max:255',
                'anggota2_nama' => 'required|string|max:255',
                // Add signature fields if needed
            ]);
            
            // Add katsinov_id if provided
            if ($request->has('katsinov_id')) {
                $validatedData['katsinov_id'] = $request->katsinov_id;
            }
            
            BeritaAcara::create($validatedData);

            return redirect()->route('admin.Katsinov.formberitaacara.index', 
                    $request->has('katsinov_id') ? ['katsinov_id' => $request->katsinov_id] : [])
                ->with('success', 'Berita Acara berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error saving berita acara: '.$e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    public function show($id)
    {
        $beritaAcara = BeritaAcara::findOrFail($id);
        $katsinov = null;
        
        if ($beritaAcara->katsinov_id) {
            $katsinov = Katsinov::find($beritaAcara->katsinov_id);
        }
        
        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.formberitaacara-show';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.formberitaacara-show';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.formberitaacara-show';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.formberitaacara-show';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.formberitaacara-show';
        }

        return view($view, compact('beritaAcara', 'katsinov'));
    }

    public function edit($id)
    {
        // Handle both cases:
        // 1. $id is a BeritaAcara ID
        // 2. $id is a Katsinov ID (when redirected from TableKatsinov)
        
        $beritaAcara = null;
        $katsinov = null;
        
        // First try to find the berita acara
        $beritaAcara = BeritaAcara::find($id);
        
        if (!$beritaAcara) {
            // If not found, try to find a Katsinov and its associated berita acara
            $katsinov = Katsinov::find($id);
            
            if (!$katsinov) {
                return redirect()->back()->with('error', 'Data not found');
            }
            
            // Try to find an existing berita acara for this katsinov
            $beritaAcara = BeritaAcara::where('katsinov_id', $katsinov->id)->first();
            
            // If no berita acara exists yet, we'll just pass the katsinov to the view
            // for a new form
        }
        else {
            // If we found a berita acara, get its associated katsinov
            if ($beritaAcara->katsinov_id) {
                $katsinov = Katsinov::find($beritaAcara->katsinov_id);
            }
        }
        
        $view = '';
        if (Auth::user()->role === 'admin_direktorat') {
            $view = 'admin.katsinov.formberitaacara';
        } else if (Auth::user()->role === 'dosen') {
            $view = 'Inovasi.dosen.formberitaacara';
        } else if (Auth::user()->role === 'admin_hilirisasi') {
            $view = 'Inovasi.admin_hilirisasi.formberitaacara';
        } else if (Auth::user()->role === 'validator') {
            $view = 'Inovasi.validator.formberitaacara';
        } else if (Auth::user()->role === 'registered_user') {
            $view = 'Inovasi.registered_user.formberitaacara';
        }

        return view($view, compact('beritaAcara', 'katsinov'));
    }

    public function update(Request $request, $id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            
            // Validate the form data
            $validatedData = $request->validate([
                'judul_inovasi' => 'required|string|max:255',
                'jenis_inovasi' => 'required|string|max:255',
                'nilai_tki' => 'required|string|max:255',
                'opini_penilai' => 'required|string',
                'tanggal' => 'required|date',
                'tempat' => 'required|string|max:255',
                'surat_keputusan' => 'required|string|max:255',
                'hari' => 'required|string|max:255',
                'tanggal_numeric' => 'required|string|max:255',
                'bulan' => 'required|string|max:255',
                'tahun' => 'required|string|max:255',
                'penanggungjawab_nama' => 'required|string|max:255',
                'ketua_tim_nama' => 'required|string|max:255',
                'anggota1_nama' => 'required|string|max:255',
                'anggota2_nama' => 'required|string|max:255',
                // Add signature fields if needed
            ]);
            
            // Preserve or update the katsinov_id
            if ($request->has('katsinov_id')) {
                $validatedData['katsinov_id'] = $request->katsinov_id;
            }
            
            $beritaAcara->update($validatedData);

            return redirect()->route('admin.Katsinov.formberitaacara.index', 
                    $beritaAcara->katsinov_id ? ['katsinov_id' => $beritaAcara->katsinov_id] : [])
                ->with('success', 'Berita Acara berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating berita acara: '.$e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data: '.$e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $beritaAcara = BeritaAcara::findOrFail($id);
            $katsinov_id = $beritaAcara->katsinov_id;
            
            $beritaAcara->delete();

            return redirect()->route('admin.Katsinov.formberitaacara.index',
                    $katsinov_id ? ['katsinov_id' => $katsinov_id] : [])
                ->with('success', 'Berita Acara berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting berita acara: '.$e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }
}
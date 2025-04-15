<?php

namespace App\Http\Controllers;

use App\Models\Sustainability;
use App\Models\SustainabilityPhoto;
use App\Http\Requests\StoreSustainabilityRequest;
use App\Http\Requests\UpdateSustainabilityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth; 

class AdminSustainabilityController extends Controller
{
    public function index()
    {
        $sustainabilities = Sustainability::with('photos')->latest()->paginate(10);

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.sustainability', compact('sustainabilities'));
        } else if (Auth::user()->role === 'prodi') {
            return view('prodi.sustainability', compact('sustainabilities'));
        } else if (Auth::user()->role === 'fakultas') {
            return view('fakultas.sustainability', compact('sustainabilities'));
        } else if (Auth::user()->role === 'admin_pemeringkatan'){
            return view('admin_pemeringkatan.sustainability', compact('sustainabilities'));
        }
    }
    
    public function store(StoreSustainabilityRequest $request)
    {
        try {
            $sustainability = Sustainability::create($request->except('foto_kegiatan'));
            
            // Pastikan sustainability berhasil dibuat
            if (!$sustainability) {
                throw new \Exception('Gagal membuat data kegiatan');
            }

            // Simpan foto
            if ($request->hasFile('foto_kegiatan')) {
                $file = $request->file('foto_kegiatan');
                $path = $file->store('sustainability', 'public');
                
                SustainabilityPhoto::create([
                    'sustainability_id' => $sustainability->id, // Pastikan ID tersedia
                    'path' => $path
                ]);
            }

            return redirect()->back()->with('success', 'Kegiatan berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyimpan kegiatan: '.$e->getMessage())
                ->withInput();
        }
    }

    public function showPublic()
    {
        $sustainabilities = Sustainability::with('photos')->latest()->get();
        return view('galeri.sustainability', compact('sustainabilities'));
    }

    /**
     * Get sustainability detail for API request
     */
    public function getSustainabilityDetail($id)
    {
        $sustainability = Sustainability::with('photos')->findOrFail($id);
        return response()->json($sustainability);
    }

    /**
     * Show the form for viewing the specified resource.
     */
    public function show(string $id)
    {
        $sustainability = Sustainability::with('photos')->findOrFail($id);
        return view('admin.sustainability.show', compact('sustainability'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implemented if needed
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Implemented if needed
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $sustainability = Sustainability::findOrFail($id);
            
            // Validate the request
            $validatedData = $request->validate([
                'judul_kegiatan' => 'required|string|max:255',
                'tanggal_kegiatan' => 'required|date',
                'fakultas' => 'required|string|max:50',
                'prodi' => 'required|string',
                'link_kegiatan' => 'nullable|url|max:255',
                'deskripsi_kegiatan' => 'required|string',
            ]);
            
            $sustainability->update($validatedData);
            
            // Handle file uploads
            if ($request->hasFile('foto_kegiatan')) {
                $file = $request->file('foto_kegiatan');
                $path = $file->store('sustainability', 'public');
                
                SustainabilityPhoto::create([
                    'sustainability_id' => $sustainability->id,
                    'path' => $path
                ]);
            }
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data kegiatan sustainability berhasil diperbarui!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Data kegiatan sustainability berhasil diperbarui!');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ]);
            }
            
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sustainability = Sustainability::with('photos')->findOrFail($id);
            
            // Delete associated photos from storage
            foreach ($sustainability->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }
            
            // Delete the sustainability record
            $sustainability->delete();
            
            return redirect()->back()->with('success', 'Data kegiatan sustainability berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Sustainability;
use App\Models\SustainabilityPhoto;
use App\Http\Requests\StoreSustainabilityRequest;
use App\Http\Requests\UpdateSustainabilityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminSustainabilityController extends Controller
{
    public function index()
    {
        $sustainabilities = Sustainability::with('photos')->latest()->paginate(10);
        return view('admin.sustainability', compact('sustainabilities'));
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

    // Method lainnya tetap ada tapi belum diimplementasikan
    public function show(string $id) {}
    public function create() {}
    public function edit(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
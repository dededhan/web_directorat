<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akreditasi;
use App\Http\Requests\StoreAkreditasiRequest;
use App\Http\Requests\UpdateAkreditasiRequest;

class AkreditasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akreditasis = Akreditasi::latest()->get();
        return view('admin.dataakreditasi', compact('akreditasis'));  
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
    public function store(StoreAkreditasiRequest $request)
    {
        Akreditasi::create($request->validated());
        
        return redirect()->back()->with('success', 'Data akreditasi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Get akreditasi detail for API request
     */
    public function getAkreditasiDetail($id)
    {
        $akreditasi = Akreditasi::findOrFail($id);
        return response()->json($akreditasi);
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
        try {
            $akreditasi = Akreditasi::findOrFail($id);
            
            // If you have UpdateAkreditasiRequest, use:
            // $validatedData = $request->validated();
            // Otherwise validate here:
            $validatedData = $request->validate([
                'fakultas' => 'required',
                'prodi' => 'required',
                'lembaga_akreditasi' => 'required',
                'peringkat' => 'required',
                'nomor_sk' => 'required|string|max:255',
                'periode_awal' => 'required|date',
                'periode_akhir' => 'required|date|after:periode_awal',
            ]);
            
            $akreditasi->update($validatedData);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data akreditasi berhasil diperbarui!'
                ]);
            }
            
            return redirect()->route('admin.dataakreditasi.index')
                ->with('success', 'Data akreditasi berhasil diperbarui!');
                
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
            $akreditasi = Akreditasi::findOrFail($id);
            $akreditasi->delete();
            
            return redirect()->route('admin.dataakreditasi.index')
                ->with('success', 'Data akreditasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
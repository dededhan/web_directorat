<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DosenInternasional;
use App\Http\Requests\StoreDosenInternasionalRequest;
use App\Http\Requests\UpdateDosenInternasionalRequest;

class DosenInternasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dosen = DosenInternasional::all();
        return view('admin.internationallecture', compact('dosen'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDosenInternasionalRequest $request)
    {
        DosenInternasional::create($request->validated());
        
        return redirect()->back()->with('success', 'Data Dosen International berhasil disimpan');
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
     * Get dosen detail for API request
     */
    public function getDosenDetail($id)
    {
        $dosen = DosenInternasional::findOrFail($id);
        return response()->json($dosen);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $dosen = DosenInternasional::findOrFail($id);
            
            // If you have UpdateDosenInternasionalRequest, use:
            // $validatedData = $request->validated();
            // Otherwise validate here:
            $validatedData = $request->validate([
                'fakultas' => 'required',
                'prodi' => 'required',
                'nama' => 'required|string|max:255',
                'negara' => 'required|string|max:255',
                'universitas_asal' => 'required|string|max:255',
                'status' => 'required|in:fulltime,parttime',
                'bidang_keahlian' => 'required|string|max:255',
            ]);
            
            $dosen->update($validatedData);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data dosen internasional berhasil diperbarui!'
                ]);
            }
            
            return redirect()->route('admin.internationallecture.index')
                ->with('success', 'Data dosen internasional berhasil diperbarui!');
                
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
            $dosen = DosenInternasional::findOrFail($id);
            $dosen->delete();
            
            return redirect()->route('admin.internationallecture.index')
                ->with('success', 'Data dosen internasional berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
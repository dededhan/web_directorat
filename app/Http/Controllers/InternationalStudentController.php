<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternationalStudent;
use App\Http\Requests\StoreInternationalStudentRequest;
use App\Http\Requests\UpdateInternationalStudentRequest;

class InternationalStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = InternationalStudent::latest()->get();
        return view('admin.mahasiswainternational', compact('students'));  
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
    public function store(StoreInternationalStudentRequest $request)
    {
        try {
            InternationalStudent::create($request->validated());
            return redirect()->back()->with('success', 'Data mahasiswa berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Get student detail for API request
     */
    public function getStudentDetail($id)
    {
        $student = InternationalStudent::findOrFail($id);
        return response()->json($student);
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
            $student = InternationalStudent::findOrFail($id);
            
            // If you have UpdateInternationalStudentRequest, use:
            // $validatedData = $request->validated();
            // Otherwise validate here:
            $validatedData = $request->validate([
                'nama_mahasiswa' => 'required|string|max:255',
                'nim' => 'nullable|string|max:50',
                'negara' => 'required|string|max:100',
                'kategori' => 'required|in:inbound,outbound',
                'status' => 'required|in:fulltime,parttime,other',
                'fakultas' => 'nullable|string|max:100',
                'program_studi' => 'nullable|string|max:100',
                'periode_mulai' => 'required|date',
                'periode_akhir' => 'required|date|after:periode_mulai',
            ]);
            
            $student->update($validatedData);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data mahasiswa internasional berhasil diperbarui!'
                ]);
            }
            
            return redirect()->route('admin.mahasiswainternational.index')
                ->with('success', 'Data mahasiswa internasional berhasil diperbarui!');
                
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
            $student = InternationalStudent::findOrFail($id);
            $student->delete();
            
            return redirect()->route('admin.mahasiswainternational.index')
                ->with('success', 'Data mahasiswa internasional berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
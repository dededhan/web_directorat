<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternationalStudent;
use App\Http\Requests\StoreInternationalStudentRequest;
use App\Http\Requests\UpdateInternationalStudentRequest;
use App\Http\Controllers\Traits\HasRoleBasedViews;

class InternationalStudentController extends Controller
{
    use HasRoleBasedViews;


    public function index(Request $request)
    {
        $query = InternationalStudent::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_mahasiswa', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('negara')) {
            $query->where('negara', 'like', "%{$request->negara}%");
        }

        $students = $query->latest()->paginate(20);
        
        return view($this->resolveViewByRole('mahasiswa-international.index'), compact('students'));  
    }
    public function create()
    {
        return view($this->resolveViewByRole('mahasiswa-international.create'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
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

        try {
            InternationalStudent::create($validated);
            return redirect()
                ->route($this->resolveRedirectByRole('mahasiswa-international.index'))
                ->with('success', 'Data mahasiswa internasional berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }
    public function getStudentDetail($id)
    {
        $student = InternationalStudent::findOrFail($id);
        return response()->json($student);
    }

    public function edit(string $id)
    {
        $student = InternationalStudent::findOrFail($id);
        return view($this->resolveViewByRole('mahasiswa-international.edit'), compact('student'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
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

        try {
            $student = InternationalStudent::findOrFail($id);
            $student->update($validated);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data mahasiswa internasional berhasil diperbarui!'
                ]);
            }
            
            return redirect()
                ->route($this->resolveRedirectByRole('mahasiswa-international.index'))
                ->with('success', 'Data mahasiswa internasional berhasil diperbarui!');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui data: ' . $e->getMessage()
                ]);
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $student = InternationalStudent::findOrFail($id);
            $student->delete();
            
            return redirect()
                ->route($this->resolveRedirectByRole('mahasiswa-international.index'))
                ->with('success', 'Data mahasiswa internasional berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
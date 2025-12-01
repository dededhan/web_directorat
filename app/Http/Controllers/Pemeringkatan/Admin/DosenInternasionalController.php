<?php

namespace App\Http\Controllers\Pemeringkatan\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\DosenInternasional;
use App\Http\Requests\StoreDosenInternasionalRequest;
use App\Http\Requests\UpdateDosenInternasionalRequest;
use App\Http\Controllers\Traits\HasRoleBasedViews;

class DosenInternasionalController extends Controller
{
    use HasRoleBasedViews;

    public function index(Request $request)
    {
        $query = DosenInternasional::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('negara', 'like', "%{$search}%")
                  ->orWhere('universitas_asal', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $lecturers = $query->latest()->paginate(20);
        
        return view($this->resolveViewByRole('international-lecture.index'), compact('lecturers'));
    }

    public function create()
    {
        return view($this->resolveViewByRole('international-lecture.create'));
    }


    public function store(StoreDosenInternasionalRequest $request)
    {
        try {
            DosenInternasional::create($request->validated());
            
            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'))
                ->with('success', 'International lecturer data has been successfully added!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to save data: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $lecturer = DosenInternasional::findOrFail($id);
        return view($this->resolveViewByRole('international-lecture.edit'), compact('lecturer'));
    }

    public function getDosenDetail($id)
    {
        $dosen = DosenInternasional::findOrFail($id);
        return response()->json($dosen);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'fakultas' => 'required',
            'prodi' => 'required',
            'nama' => 'required|string|max:255',
            'negara' => 'required|string|max:255',
            'universitas_asal' => 'required|string|max:255',
            'status' => 'required|in:fulltime,parttime',
            'bidang_keahlian' => 'required|string|max:255',
        ]);

        try {
            $lecturer = DosenInternasional::findOrFail($id);
            $lecturer->update($validatedData);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'International lecturer data has been successfully updated!'
                ]);
            }
            
            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'))
                ->with('success', 'International lecturer data has been successfully updated!');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update data: ' . $e->getMessage()
                ]);
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update data: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $lecturer = DosenInternasional::findOrFail($id);
            $lecturer->delete();
            
            return redirect()
                ->route($this->resolveRedirectByRole('international-lecture.index'))
                ->with('success', 'International lecturer data has been successfully deleted!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }
}
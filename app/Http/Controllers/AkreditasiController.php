<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akreditasi;
use App\Http\Requests\StoreAkreditasiRequest;
use App\Http\Requests\UpdateAkreditasiRequest;
use App\Http\Controllers\Traits\HasRoleBasedViews;

class AkreditasiController extends Controller
{
    use HasRoleBasedViews;

    public function index(Request $request)
    {
        $query = Akreditasi::query();

        // Apply filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('prodi', 'like', "%{$search}%")
                  ->orWhere('nomor_sk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('lembaga')) {
            $query->where('lembaga_akreditasi', $request->lembaga);
        }

        if ($request->filled('peringkat')) {
            $query->where('peringkat', $request->peringkat);
        }
        $akreditasis = $query->latest()->paginate(20);

        return view($this->resolveViewByRole('data-akreditasi.index'), compact('akreditasis'));
    }
    public function create()
    {
        return view($this->resolveViewByRole('data-akreditasi.create'));
    }

    public function store(StoreAkreditasiRequest $request)
    {
        Akreditasi::create($request->validated());
        
        return redirect()
            ->route($this->resolveRedirectByRole('data-akreditasi.index'))
            ->with('success', 'Data akreditasi berhasil disimpan');
    }

    public function show(string $id)
    {
        //
    }

    public function getAkreditasiDetail($id)
    {
        $akreditasi = Akreditasi::findOrFail($id);
        return response()->json($akreditasi);
    }

    public function edit(string $id)
    {
        $akreditasi = Akreditasi::findOrFail($id);
        return view($this->resolveViewByRole('data-akreditasi.edit'), compact('akreditasi'));
    }


    public function update(Request $request, string $id)
    {
        try {
            $akreditasi = Akreditasi::findOrFail($id);
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
            
            return redirect()
                ->route($this->resolveRedirectByRole('data-akreditasi.index'))
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

    public function destroy(string $id)
    {
        try {
            $akreditasi = Akreditasi::findOrFail($id);
            $akreditasi->delete();
            
            return redirect()
                ->route($this->resolveRedirectByRole('data-akreditasi.index'))
                ->with('success', 'Data akreditasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
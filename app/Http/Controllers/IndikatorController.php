<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    private function getRoutePrefix()
    {
        if (auth()->user()->role === 'admin_direktorat') {
            return 'admin';
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }
        return 'admin';
    }

    public function index()
    {
        $indikators = Indikator::orderBy('id', 'asc')->get();
        $routePrefix = $this->getRoutePrefix();

        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.indikator_dashboard', compact('indikators', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.indikator_dashboard', compact('indikators', 'routePrefix'));
        }

        return view('admin.indikator_dashboard', compact('indikators', 'routePrefix'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'deskripsi' => 'required|string',
            ]);

            $indikator = Indikator::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'section' => $request->judul // Use judul as section or any default value
            ]);

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.indikator.index')
                ->with('success', 'Indikator berhasil disimpan!');
            
        } catch (\Exception $e) {
            \Log::error('Error storing indikator: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan indikator: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function getIndikatorDetail($id)
    {
        $indikator = Indikator::findOrFail($id);
        return response()->json($indikator);
    }

    public function update(Request $request, string $id)
    {
        try {
            $indikator = Indikator::findOrFail($id);
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'deskripsi' => 'required|string',
            ]);

            $indikator->judul = $validated['judul'];
            $indikator->deskripsi = $validated['deskripsi'];
            $indikator->section = $validated['judul']; // Use judul as section
            $indikator->save();

            $routePrefix = $this->getRoutePrefix();
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Indikator berhasil diperbarui!']);
            }
            return redirect()->route($routePrefix . '.indikator.index')
                ->with('success', 'Indikator berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating indikator: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui indikator: ' . $e->getMessage()]);
            }
            return redirect()->back()
                ->with('error', 'Gagal memperbarui indikator: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $indikator = Indikator::findOrFail($id);
            $indikator->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.indikator.index')
                ->with('success', 'Indikator berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting indikator: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus indikator: ' . $e->getMessage());
        }
    }

    public function showAllIndikators()
    {
        $indikators = Indikator::orderBy('id', 'asc')->get();
        return view('Pemeringkatan.indikator.indikator', compact('indikators'));
    }
}
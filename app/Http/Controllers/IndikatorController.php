<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\HasRoleBasedViews;
use Illuminate\Support\Facades\Storage;

class IndikatorController extends Controller
{
    use HasRoleBasedViews;

    public function index()
    {
        $indikators = Indikator::orderBy('id', 'asc')->get();
        return view($this->resolveViewByRole('indikator.index'), compact('indikators'));
    }

    public function create()
    {
        return view($this->resolveViewByRole('indikator.create'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'judul' => 'required|string|max:200',
                'deskripsi' => 'required|string',
            ]);

            $indikator = Indikator::create([
                'judul' => $validated['judul'],
                'deskripsi' => $validated['deskripsi'],
                'section' => $validated['judul']
            ]);
            
            return redirect()->route($this->resolveRedirectByRole('indikator.index'))
                ->with('success', 'Indikator berhasil disimpan!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
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

    public function edit(string $id)
    {
        $indikator = Indikator::findOrFail($id);
        return view($this->resolveViewByRole('indikator.edit'), compact('indikator'));
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
            $indikator->section = $validated['judul'];
            $indikator->save();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Indikator berhasil diperbarui!']);
            }
            return redirect()->route($this->resolveRedirectByRole('indikator.index'))
                ->with('success', 'Indikator berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()]);
            }
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
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

            return redirect()->route($this->resolveRedirectByRole('indikator.index'))
                ->with('success', 'Indikator berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting indikator: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus indikator: ' . $e->getMessage());
        }
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('upload')->store('indikator_images', 'public');
        $url = Storage::url($path);

        return response()->json([
            'url' => asset($url),
        ]);
    }

    public function showAllIndikators()
    {
        $indikators = Indikator::orderBy('id', 'asc')->get();
        return view('Pemeringkatan.indikator.indikator', compact('indikators'));
    }
}

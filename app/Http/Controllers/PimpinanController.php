<?php

namespace App\Http\Controllers;

use App\Models\Pimpinan;
use Illuminate\Http\Request;
use App\Http\Requests\StorePimpinanRequest;
use Illuminate\Support\Facades\Storage;

class PimpinanController extends Controller
{
    /**
     * Get the correct route name prefix based on authenticated user role
     */
    private function getRoutePrefix()
    {
        if (auth()->user()->role === 'admin_direktorat') {
            return 'admin';
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        } else if (auth()->user()->role === 'admin_inovasi') {
            return 'subdirektorat-inovasi.admin_inovasi';
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return 'admin_pemeringkatan';
        }

        return 'admin';
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pimpinans = Pimpinan::all();
        $routePrefix = $this->getRoutePrefix();

        if (auth()->user()->role === 'admin_direktorat') {
            return view('admin.pimpinan_dashboard', compact('pimpinans', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_hilirisasi') {
            return view('subdirektorat-inovasi.admin_hilirisasi.pimpinan_dashboard', compact('pimpinans', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_inovasi') {
            return view('subdirektorat-inovasi.admin_inovasi.pimpinan_dashboard', compact('pimpinans', 'routePrefix'));
        } else if (auth()->user()->role === 'admin_pemeringkatan') {
            return view('admin_pemeringkatan.pimpinan_dashboard', compact('pimpinans', 'routePrefix'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePimpinanRequest $request)
    {
        try {
            // Check if image exists and is valid
            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'pimpinan-images',
                    $namaFile,
                    'public'
                );

                // Create the pimpinan record with the image path
                Pimpinan::create([
                    'nama' => $request->nama,
                    'jabatan' => $request->jabatan,
                    'deskripsi' => $request->deskripsi,
                    'gambar' => $gambarPath
                ]);

                $routePrefix = $this->getRoutePrefix();
                return redirect()->route($routePrefix . '.pimpinan.index')
                    ->with('success', 'Data pimpinan berhasil disimpan!');
            } else {
                // Handle the case where image upload failed
                return redirect()->back()
                    ->with('error', 'Upload gambar gagal. Pastikan file gambar valid.')
                    ->withInput();
            }
        } catch (\Exception $e) {
            // Log the error and return with error message
            \Log::error('Error storing pimpinan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data pimpinan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the public view of pimpinan page.
     */
    public function showPublic()
    {
        // Get the director
        $direktur = Pimpinan::where('jabatan', 'Direktur Inovasi Sistem Informasi dan Pemeringkatan')->first();
        
        // Get the subdirectors
        $kasubdits = Pimpinan::where('jabatan', '!=', 'Direktur Inovasi Sistem Informasi dan Pemeringkatan')
            ->get();
        
        // Always provide these variables, even if they're empty
        return view('pimpinan.pimpinan', compact('direktur', 'kasubdits'));
    }

    /**
     * Get Pimpinan detail for AJAX request
     */
    public function getPimpinanDetail($id)
    {
        $pimpinan = Pimpinan::findOrFail($id);
        return response()->json($pimpinan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $pimpinan = Pimpinan::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'jabatan' => 'required|in:Direktur Inovasi Sistem Informasi dan Pemeringkatan,Kepala Subdirektorat Inovasi dan Hilirisai,Kepala Subdirektorat Sistem Informasi dan Pemeringkatan',
                'deskripsi' => 'required|string',
                'gambar' => 'nullable|image|max:2048',
            ]);

            // Update the text fields
            $pimpinan->nama = $validated['nama'];
            $pimpinan->jabatan = $validated['jabatan'];
            $pimpinan->deskripsi = $validated['deskripsi'];

            // Handle image update if a new one was uploaded
            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                // Delete old image
                if ($pimpinan->gambar && Storage::disk('public')->exists($pimpinan->gambar)) {
                    Storage::disk('public')->delete($pimpinan->gambar);
                }

                // Store new image
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'pimpinan-images',
                    $namaFile,
                    'public'
                );

                $pimpinan->gambar = $gambarPath;
            }

            $pimpinan->save();

            $routePrefix = $this->getRoutePrefix();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data pimpinan berhasil diperbarui!']);
            }

            return redirect()->route($routePrefix . '.pimpinan.index')
                ->with('success', 'Data pimpinan berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating pimpinan: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui data pimpinan: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui data pimpinan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $pimpinan = Pimpinan::findOrFail($id);

            // Delete the image file from storage
            if ($pimpinan->gambar && Storage::disk('public')->exists($pimpinan->gambar)) {
                Storage::disk('public')->delete($pimpinan->gambar);
            }

            // Delete the record
            $pimpinan->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.pimpinan.index')
                ->with('success', 'Data pimpinan berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting pimpinan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus data pimpinan: ' . $e->getMessage());
        }
    }

    /**
     * Handle image upload from editor
     */
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('upload')->store('pimpinan_images', 'public');
        $url = Storage::url($path);

        return response()->json([
            'url' => asset($url),
        ]);
    }
}
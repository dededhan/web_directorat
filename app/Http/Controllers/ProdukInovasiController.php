<?php

namespace App\Http\Controllers;

use App\Models\ProdukInovasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProdukInovasiController extends Controller
{
    /**
     * Get the correct route name prefix based on authenticated user role
     */
    private function getRoutePrefix()
    {
        if (auth()->user()->hasRole('admin_direktorat')) {
            return 'admin';
        } else if (auth()->user()->hasRole('admin_hilirisasi')) {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        }
        
        return 'admin'; // Default fallback
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produkInovasi = ProdukInovasi::all();
        $routePrefix = $this->getRoutePrefix();
        
        if (auth()->user()->hasRole('admin_direktorat')) {
            return view('admin.katsinov.produk_inovasi', compact('produkInovasi', 'routePrefix'));
        } elseif (auth()->user()->hasRole('admin_hilirisasi')) {
            return view('subdirektorat-inovasi.admin_hilirisasi.produk_inovasi', compact('produkInovasi', 'routePrefix'));
        }
        
        // Default fallback view
        return view('admin.katsinov.produk_inovasi', compact('produkInovasi', 'routePrefix'));
    }

    /**
     * Display a listing of the resource for public view.
     */
    public function publicIndex()
    {
        // Get all products ordered by most recent first
        $produkInovasi = ProdukInovasi::latest()->get();

        return view('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi', compact('produkInovasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'inovator' => 'required|string|max:255',
            'nomor_paten' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('produk_inovasi', $fileName, 'public');
                $data['gambar'] = $filePath;
            }

            ProdukInovasi::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk inovasi berhasil ditambahkan!'
                ]);
            }

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.Katsinov.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan produk inovasi: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk inovasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get the detail of a product for AJAX request.
     */
    public function getProdukDetail($id)
    {
        $produk = ProdukInovasi::findOrFail($id);
        return response()->json($produk);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'inovator' => 'required|string|max:255',
            'nomor_paten' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $produk = ProdukInovasi::findOrFail($id);
            $data = $request->except('gambar');

            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                    Storage::disk('public')->delete($produk->gambar);
                }

                $file = $request->file('gambar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('produk_inovasi', $fileName, 'public');
                $data['gambar'] = $filePath;
            }

            $produk->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk inovasi berhasil diperbarui!'
                ]);
            }

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.Katsinov.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui produk inovasi: ' . $e->getMessage()
                ]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui produk inovasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $produk = ProdukInovasi::findOrFail($id);

            // Delete image if exists
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            $produk->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk inovasi berhasil dihapus!'
                ]);
            }

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.Katsinov.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil dihapus!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus produk inovasi: ' . $e->getMessage()
                ]);
            }

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.Katsinov.produk_inovasi')
                ->with('error', 'Gagal menghapus produk inovasi: ' . $e->getMessage());
        }
    }

    /**
     * Handle image uploads from CKEditor
     */
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            
            // Validate mime type and size
            $validator = \Validator::make(['upload' => $file], [
                'upload' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'error' => [
                        'message' => $validator->errors()->first('upload')
                    ]
                ]);
            }
            
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('produk_inovasi/editor', $fileName, 'public');
            
            return response()->json([
                'url' => Storage::url($filePath)
            ]);
        }
        
        return response()->json([
            'error' => [
                'message' => 'No file uploaded'
            ]
        ]);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ProdukInovasi;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProdukInovasiRequest;
use Illuminate\Support\Facades\Storage;

class ProdukInovasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function publicIndex()
    {
        // Get all products ordered by most recent first
        $produkInovasi = ProdukInovasi::latest()->get();
        
        return view('subdirektorat-inovasi.riset_unj.produk_inovasi.produkinovasi', compact('produkInovasi'));
    }
    
    /**
     * Alternative public view showing the same data but for the Inovasi path
     */
    public function publicIndexAlt()
    {
        // Get all products ordered by most recent first
        $produkInovasi = ProdukInovasi::latest()->get();
        
        return view('Inovasi.riset_unj.produk_inovasi.produkinovasi', compact('produkInovasi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukInovasiRequest $request)
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('gambar')) {
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'produk-inovasi-images',
                    $namaFile,
                    'public'
                );
                
                $data['gambar'] = $gambarPath;
            }

            // Create the product
            ProdukInovasi::create($data);
            
            return redirect()->route('admin.Katsinov.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil disimpan!');
        } catch (\Exception $e) {
            \Log::error('Error storing product: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get detail of a product for edit modal.
     */
    public function getProdukDetail($id)
    {
        $produk = ProdukInovasi::findOrFail($id);
        return response()->json($produk);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $produk = ProdukInovasi::findOrFail($id);

            // Validate the request
            $validated = $request->validate([
                'nama_produk' => 'required|string|max:1500',
                'inovator' => 'required|string|max:1500',
                'deskripsi' => 'required|string|max:1500',
                'nomor_paten' => 'nullable|string|max:255',
                'gambar' => 'nullable|image|max:2048',
            ]);

            // Update the text fields
            $produk->nama_produk = $validated['nama_produk'];
            $produk->inovator = $validated['inovator'];
            $produk->deskripsi = $validated['deskripsi'];
            $produk->nomor_paten = $validated['nomor_paten'];

            // Handle image update if a new one was uploaded
            if ($request->hasFile('gambar') && $request->file('gambar')->isValid()) {
                // Delete old image
                if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                    Storage::disk('public')->delete($produk->gambar);
                }

                // Store new image
                $namaFile = time() . '_' . uniqid() . '.' . $request->file('gambar')->getClientOriginalExtension();
                $gambarPath = $request->file('gambar')->storeAs(
                    'produk-inovasi-images',
                    $namaFile,
                    'public'
                );

                $produk->gambar = $gambarPath;
            }

            $produk->save();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui!']);
            }

            return redirect()->route('admin.Katsinov.produk_inovasi')
                ->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating product: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui produk: ' . $e->getMessage()]);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $produk = ProdukInovasi::findOrFail($id);

            // Delete the image file from storage
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
         
            // Delete the record
            $produk->delete();
            
            return redirect()->route('admin.Katsinov.produk_inovasi')
                ->with('success', 'Produk inovasi berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Handle CKEditor image upload.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('upload')->store('produk_inovasi_images', 'public');
        $url = Storage::url($path);

        return response()->json([
            'url' => asset($url),
        ]);
    }
}
<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MitraKolaborasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraKolaborasiController extends Controller
{
    /**
     * Menentukan prefix rute berdasarkan role user.
     */
    private function getRoutePrefix()
    {
         if (auth()->user()->hasRole('admin_direktorat')) {
            return 'admin';
        } else if (auth()->user()->hasRole('admin_hilirisasi')) {
            return 'subdirektorat-inovasi.admin_hilirisasi';
        }
        return 'admin'; 
    }

    /**
     * Menampilkan halaman utama CRUD Mitra Kolaborasi.
     */
    public function index()
    {
        $mitraKolaborasi = MitraKolaborasi::all();
        $routePrefix = $this->getRoutePrefix();
        
        // Mengarahkan ke view formmitra.blade.php
        return view('admin.formmitra', compact('mitraKolaborasi', 'routePrefix'));
    }
    /**
     * Menyimpan data mitra baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link_website' => 'required|url',
            'kategori' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        try {
            $data = $request->all();

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('mitra_kolaborasi', $fileName, 'public');
                $data['foto'] = $filePath;
            }

            MitraKolaborasi::create($data);

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.mitra-kolaborasi.index')
                             ->with('success', 'Mitra kolaborasi berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                             ->with('error', 'Gagal menambahkan mitra: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Mengambil detail mitra untuk modal edit (AJAX).
     */
    public function getMitraDetail($id)
    {
        $mitra = MitraKolaborasi::findOrFail($id);
        return response()->json($mitra);
    }

    /**
     * Mengupdate data mitra.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link_website' => 'required|url',
            'kategori' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // foto opsional saat update
        ]);

        try {
            $mitra = MitraKolaborasi::findOrFail($id);
            $data = $request->except('foto');

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Hapus foto lama jika ada
                if ($mitra->foto && Storage::disk('public')->exists($mitra->foto)) {
                    Storage::disk('public')->delete($mitra->foto);
                }

                $file = $request->file('foto');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('mitra_kolaborasi', $fileName, 'public');
                $data['foto'] = $filePath;
            }

            $mitra->update($data);

            // Respon untuk AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Mitra kolaborasi berhasil diperbarui!'
                ]);
            }

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.mitra-kolaborasi.index')
                             ->with('success', 'Mitra kolaborasi berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui mitra: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()
                             ->with('error', 'Gagal memperbarui mitra: ' . $e->getMessage())
                             ->withInput();
        }
    }

    /**
     * Menghapus data mitra.
     */
    public function destroy($id)
    {
        try {
            $mitra = MitraKolaborasi::findOrFail($id);

            // Hapus foto dari storage
            if ($mitra->foto && Storage::disk('public')->exists($mitra->foto)) {
                Storage::disk('public')->delete($mitra->foto);
            }

            $mitra->delete();

            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.mitra-kolaborasi.index')
                             ->with('success', 'Mitra kolaborasi berhasil dihapus!');
        } catch (\Exception $e) {
            $routePrefix = $this->getRoutePrefix();
            return redirect()->route($routePrefix . '.mitra-kolaborasi.index')
                             ->with('error', 'Gagal menghapus mitra: ' . $e->getMessage());
        }
    }
     public function showPublicByCategory(Request $request)
    {
        $kategoriSlug = $request->query('kategori', 'pendidikan');

        // Mapping dari slug di URL ke nama kategori di database
        $kategoriMapping = [
            'pendidikan' => 'Pendidikan',
            'sains-teknologi' => 'Sains & Teknologi',
            'sosial-humaniora-seni' => 'Sosial Humaniora & Seni',
            'kesehatan-psikologi' => 'Kesehatan & Psikologi',
        ];

        // Data statis untuk deskripsi, ikon, dll.
        $detailData = [
             'pendidikan' => [
                'title' => 'Pendidikan', 'icon' => 'fa-school',
                'description' => 'Kolaborasi strategis dengan berbagai institusi pendidikan untuk meningkatkan mutu pembelajaran, mengembangkan teknologi edukasi terapan, dan mencetak talenta masa depan yang unggul.',
            ],
            'sains-teknologi' => [
                'title' => 'Sains & Teknologi', 'icon' => 'fa-flask',
                'description' => 'Bermitra dengan industri teknologi terdepan dan lembaga riset untuk mendorong batas-batas inovasi, menciptakan solusi masa depan, dan mempercepat transformasi digital di Indonesia.',
            ],
            'sosial-humaniora-seni' => [
                'title' => 'Sosial Humaniora & Seni', 'icon' => 'fa-palette',
                'description' => 'Menggali potensi kreativitas dan kearifan lokal melalui kolaborasi di bidang sosial, humaniora, dan seni untuk mengembangkan inovasi yang memperkaya kehidupan masyarakat.',
            ],
            'kesehatan-psikologi' => [
                'title' => 'Kesehatan & Psikologi', 'icon' => 'fa-heart-pulse',
                'description' => 'Bekerja sama dengan institusi kesehatan dan para ahli untuk menciptakan inovasi terapan yang meningkatkan kesejahteraan fisik dan mental masyarakat.',
            ],
        ];

        $kategoriDB = $kategoriMapping[$kategoriSlug] ?? 'Pendidikan';
        $partners = MitraKolaborasi::where('kategori', $kategoriDB)->get();
        $data = $detailData[$kategoriSlug] ?? $detailData['pendidikan'];

        // Ganti 'mitra-kategori' dengan path view Anda yang benar
        return view('subdirektorat-inovasi.riset_unj.produk_inovasi.mitra-kolaborasi', compact('data', 'partners'));
    }
}
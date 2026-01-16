<?php

namespace App\Http\Controllers;


use App\Models\AlumniBerdampak;
use App\Http\Requests\StoreAlumniBerdampakRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class AdminAlumniBerdampakController extends Controller
{
    /**
     * Helper to get faculty and program data for views.
     */
    private function getFacultyProgramDataForView()
    {
        return [
            'PASCASARJANA' => ['name' => 'Pascasarjana', 'programs' => ['S3 Penelitian Dan Evaluasi Pendidikan', 'S2 Penelitian Dan Evaluasi Pendidikan', 'S2 Manajemen Lingkungan', 'S3 Ilmu Manajemen', 'S3 Manajemen Pendidikan', 'S3 Pendidikan Dasar', 'S2 Linguistik Terapan', 'S3 Pendidikan Kependudukan Dan Lingkungan Hidup', 'S2 Pendidikan Lingkungan', 'S3 Pendidikan Jasmani', 'S3 Teknologi Pendidikan', 'S3 Linguistik Terapan', 'S3 Pendidikan Anak Usia Dini', 'S2 Manajemen Pendidikan Tinggi']],
            'FIP' => ['name' => 'FIP (Fakultas Ilmu Pendidikan)', 'programs' => ['S2 Bimbingan Konseling', 'S1 Bimbingan Dan Konseling', 'S1 Pendidikan Luar Biasa', 'S1 Manajemen Pendidikan', 'S1 Pendidikan Masyarakat', 'S1 Pendidikan Guru Pendidikan Anak Usia Dini', 'S2 Pendidikan Dasar', 'S2 Teknologi Pendidikan', 'S1 Pendidikan Guru Sekolah Dasar', 'S1 Teknologi Pendidikan', 'S2 Pendidikan Masyarakat', 'S2 Pendidikan Khusus', 'S1 Perpustakaan dan Sains Informasi']],
            'FMIPA' => ['name' => 'FMIPA (Fakultas Matematika dan Ilmu Pengetahuan Alam)', 'programs' => ['S1 Kimia', 'S1 Statistika', 'S1 Matematika', 'S1 Pendidikan Matematika', 'S1 Biologi', 'S1 Ilmu Komputer', 'S1 Fisika', 'S2 Pendidikan Kimia', 'S2 Pendidikan Biologi', 'S2 Pendidikan Matematika', 'S1 Pendidikan Biologi', 'S1 Pendidikan Fisika', 'S1 Pendidikan Kimia', 'S2 Pendidikan Fisika']],
            'FPPSI' => ['name' => 'FPPSI (Fakultas Psikologi)', 'programs' => ['S1 Psikologi', 'S2 Psikologi']],
            'FBS' => ['name' => 'FBS (Fakultas Bahasa dan Seni)', 'programs' => ['S1 Pendidikan Musik', 'S1 Pendidikan Tari', 'S1 Pendidikan Seni Rupa', 'S1 Pendidikan Bahasa Jepang', 'S1 Sastra Indonesia', 'S1 Pendidikan Bahasa Dan Sastra Indonesia', 'S1 Pendidikan Bahasa Perancis', 'S1 Sastra Inggris', 'S1 Pendidikan Bahasa Jerman', 'S1 Pendidikan Bahasa Inggris', 'S2 Pendidikan Bahasa Inggris', 'S1 Pendidikan Bahasa Arab', 'S2 Pendidikan Bahasa Arab', 'S1 Pendidikan Bahasa Mandarin', 'S2 Pendidikan Seni']],
            'FT' => ['name' => 'FT (Fakultas Teknik)', 'programs' => ['S1 Pendidikan Teknik Elektronika', 'D4 Kosmetik dan Perawatan Kecantikan', 'D4 Teknik Rekayasa Manufaktur', 'D4 Seni Kuliner dan Pengolahan Jasa Makanan', 'D4 Desain mode', 'D4 Manajemen Pelabuhan dan Logistik Maritim', 'S1 Pendidikan Teknik Informatika Dan Komputer', 'S1 Pendidikan Tata Boga', 'S1 Pendidikan Tata Busana', 'S1 Pendidikan Tata Rias', 'S1 Pendidikan Kesejahteraan Keluarga', 'S2 Pendidikan Teknologi Dan Kejuruan', 'S1 Pendidikan Teknik Bangunan', 'S1 Pendidikan Teknik Elektro', 'S1 Pendidikan Teknik Mesin', 'D4 Teknik Rekayasa Otomasi', 'D4 Teknologi Rekayasa Konstruksi Bangunan Gedung', 'S1 Rekayasa Keselamatan Kebakaran', 'S1 Teknik Mesin', 'S1 Sistem dan Teknologi Informasi']],
            'FIK' => ['name' => 'FIK (Fakultas Ilmu Keolahragaan)', 'programs' => ['S1 Ilmu Keolahragaan', 'S1 Pendidikan Kepelatihan Olahraga', 'S1 Pendidikan Jasmani, Kesehatan Dan Rekreasi', 'S2 Pendidikan Jasmani', 'S1 Kepelatihan Kecabangan Olahraga', 'S1 Olahraga Rekreasi', 'S2 Ilmu Keolahragaan']],
            'FIS' => ['name' => 'FIS (Fakultas Ilmu Sosial)', 'programs' => ['D4 Usaha Perjalanan Wisata', 'S1 Sosiologi', 'S1 Pendidikan Agama Islam', 'S1 Pendidikan Sosiologi', 'S2 Pendidikan Sejarah', 'D4 Hubungan Masyarakat dan Komunikasi Digital', 'S1 Pendidikan Pancasila Dan Kewarganegaraan', 'S1 Pendidikan Geografi', 'S1 Pendidikan IPS', 'S1 Pendidikan Sejarah', 'S1 Ilmu Komunikasi (ILKOM)', 'S1 Geografi', 'S2 Pendidikan Geografi', 'S2 Pendidikan Pancasila Dan Kewarganegaraan']],
            'FE' => ['name' => 'FE (Fakultas Ekonomi)', 'programs' => ['D4 Akuntansi Sektor Publik', 'D4 Administrasi Perkantoran Digital', 'D4 Pemasaran Digital', 'S1 Akuntansi', 'S1 Manajemen', 'S1 Pendidikan Ekonomi', 'S2 Manajemen', 'S1 Pendidikan Administrasi Perkantoran', 'S1 Bisnis Digital', 'S2 Akuntansi', 'S1 Pendidikan Akuntansi', 'S2 Pendidikan Ekonomi', 'S1 Pendidikan Bisnis']],
            'PROFESI' => ['name' => 'Program Profesi', 'programs' => ['Profesi PPG']]
        ];
    }

    public function index()
    {
       $alumniBerdampak = AlumniBerdampak::with('user')->latest()->paginate(10);

        $viewMap = [
            'admin_direktorat' => 'admin.alumniberdampak',
            'prodi' => 'prodis.alumniberdampak',
            'fakultas' => 'fakultas.alumniberdampak',
            'admin_pemeringkatan' => 'admin_pemeringkatan.alumni-berdampak.index',
        ];

        $view = $viewMap[Auth::user()->role] ?? 'admin.alumniberdampak';
        $viewData = ['alumniBerdampak' => $alumniBerdampak];

        // Add faculties data for admin_pemeringkatan
        if (Auth::user()->role === 'admin_pemeringkatan') {
            $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
        }

        return view($view, $viewData);
    }

    public function create()
    {
        $viewMap = [
            'admin_direktorat' => 'admin.alumniberdampak-create',
            'prodi' => 'prodis.alumniberdampak-create',
            'fakultas' => 'fakultas.alumniberdampak-create',
            'admin_pemeringkatan' => 'admin_pemeringkatan.alumni-berdampak.create',
        ];

        $view = $viewMap[Auth::user()->role] ?? 'admin.alumniberdampak-create';
        $viewData = [];

        // Add faculties data for admin_pemeringkatan
        if (Auth::user()->role === 'admin_pemeringkatan') {
            $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
        }

        return view($view, $viewData);
    }

    public function store(StoreAlumniBerdampakRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        AlumniBerdampak::create($data);

        $routeMap = [
            'admin_direktorat' => 'admin.alumniberdampak.index',
            'prodi' => 'prodis.alumniberdampak.index',
            'fakultas' => 'fakultas.alumniberdampak.index',
            'admin_pemeringkatan' => 'admin_pemeringkatan.alumni-berdampak.index',
        ];

        $route = $routeMap[Auth::user()->role] ?? 'admin.alumniberdampak.index';

        return redirect()->route($route)->with('success', 'Data berhasil disimpan!');
    }


    public function edit($id)
    {
        $alumni_berdampak = AlumniBerdampak::findOrFail($id);
        
        $viewMap = [
            'admin_direktorat' => 'admin.alumniberdampak-edit',
            'prodi' => 'prodis.alumniberdampak-edit',
            'fakultas' => 'fakultas.alumniberdampak-edit',
            'admin_pemeringkatan' => 'admin_pemeringkatan.alumni-berdampak.edit',
        ];

        $view = $viewMap[Auth::user()->role] ?? 'admin.alumniberdampak-edit';
        $viewData = ['alumniBerdampak' => $alumni_berdampak];

        // Add faculties data for admin_pemeringkatan
        if (Auth::user()->role === 'admin_pemeringkatan') {
            $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
        }

        return view($view, $viewData);
    }

    public function update(StoreAlumniBerdampakRequest $request, $id)
    {
        $alumni_berdampak = AlumniBerdampak::findOrFail($id);
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($alumni_berdampak->image) {
                Storage::disk('public')->delete($alumni_berdampak->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $alumni_berdampak->update($data);

        $routeMap = [
            'admin_direktorat' => 'admin.alumniberdampak.index',
            'prodi' => 'prodis.alumniberdampak.index',
            'fakultas' => 'fakultas.alumniberdampak.index',
            'admin_pemeringkatan' => 'admin_pemeringkatan.alumni-berdampak.index',
        ];

        $route = $routeMap[Auth::user()->role] ?? 'admin.alumniberdampak.index';

        // Add AJAX support
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);
        }

        return redirect()->route($route)->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $alumni_berdampak = AlumniBerdampak::findOrFail($id);
        
        if ($alumni_berdampak->image) {
            Storage::disk('public')->delete($alumni_berdampak->image);
        }
        $alumni_berdampak->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }
}
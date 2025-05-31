<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User; // Added
use Illuminate\Http\Request;
use App\Http\Requests\StoreMataKuliahRequest; // Assuming this will be updated for conditional validation
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Added

class AdminMataKuliahController extends Controller
{
    /**
     * Helper function to get faculty and prodi from user name.
     */
    private function getUserFacultyProdiInfo(User $user)
    {
        $userFaculty = null;
        $userProdi = null;
        $userFacultyKeyForData = null;

        if ($user->role === 'fakultas') {
            $userFaculty = strtolower($user->name);
            $userFacultyKeyForData = strtoupper($user->name);
        } elseif ($user->role === 'prodi') {
            $parts = explode('-', $user->name, 2);
            if (count($parts) === 2) {
                $userFaculty = strtolower($parts[0]);
                $userFacultyKeyForData = strtoupper($parts[0]);
                $userProdi = $parts[1];
            } else {
                Log::warning('Unexpected name format for prodi user for Mata Kuliah: ' . $user->name . ' ID: ' . $user->id);
                $userFaculty = strtolower($user->name); // Fallback, though likely an error
                $userFacultyKeyForData = strtoupper($user->name);
            }
        }
        return ['faculty_code' => $userFaculty, 'prodi_name' => $userProdi, 'faculty_key' => $userFacultyKeyForData];
    }

    /**
     * Helper to get redirect route name based on user role and action.
     */
    private function getRoleBasedRouteName(string $actionSuffix)
    {
        $user = Auth::user();
        if (!$user) return 'login';

        $role = $user->role;
        $baseRouteName = 'matakuliah.' . $actionSuffix;

        switch ($role) {
            case 'admin_direktorat':
                return 'admin.' . $baseRouteName;
            case 'fakultas':
                return 'fakultas.' . $baseRouteName;
            case 'prodi':
                return 'prodi.' . $baseRouteName;
            case 'admin_pemeringkatan':
                return 'admin_pemeringkatan.' . $baseRouteName;
            default:
                Log::warning('Trying to get role based route for matakuliah for unhandled role: ' . $role);
                return 'dashboard';
        }
    }

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $matakuliahsQuery = MataKuliah::query()->latest(); // Use query() for chaining, and latest()
        $userInfo = $this->getUserFacultyProdiInfo($user);

        if ($role === 'admin_direktorat' || $role === 'admin_pemeringkatan') {
            $matakuliahs = $matakuliahsQuery->paginate(10); // Paginate for admin views
        } elseif ($role === 'fakultas') {
            if ($userInfo['faculty_code']) {
                $matakuliahsQuery->where('fakultas', $userInfo['faculty_code']);
            } else {
                Log::warning('Mata Kuliah: Fakultas user has no faculty_code.', ['user_id' => $user->id, 'user_name' => $user->name]);
                $matakuliahsQuery->whereRaw('1 = 0');
            }
            $matakuliahs = $matakuliahsQuery->paginate(10);
        } elseif ($role === 'prodi') {
            if ($userInfo['faculty_code'] && $userInfo['prodi_name']) {
                $matakuliahsQuery->where('fakultas', $userInfo['faculty_code'])
                    ->where('prodi', $userInfo['prodi_name']);
            } else {
                Log::warning('Mata Kuliah: Prodi user has no faculty_code or prodi_name.', ['user_id' => $user->id, 'user_name' => $user->name]);
                $matakuliahsQuery->whereRaw('1 = 0');
            }
            $matakuliahs = $matakuliahsQuery->paginate(10);
        } else {
            Log::error('Unhandled role in Mata Kuliah index: ' . $role, ['user_id' => $user->id]);
            return redirect('/')->with('error', 'Unauthorized access to Mata Kuliah index.');
        }

        $viewName = '';
        $viewData = ['matakuliahs' => $matakuliahs, 'user_info' => $userInfo];

        switch ($role) {
            case 'admin_direktorat':
                $viewName = 'admin.matakuliah';
                $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
                break;
            case 'prodi':
                $viewName = 'prodi.matakuliah';
                break;
            case 'fakultas':
                $viewName = 'fakultas.matakuliah';
                if ($userInfo['faculty_key']) {
                    $allFacultiesData = $this->getFacultyProgramDataForView();
                    $viewData['prodi_list_for_fakultas'] = $allFacultiesData[strtoupper($userInfo['faculty_key'])]['programs'] ?? [];
                } else {
                    $viewData['prodi_list_for_fakultas'] = [];
                }
                break;
            case 'admin_pemeringkatan':
                $viewName = 'admin_pemeringkatan.matakuliah';
                $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
                break;
            default:
                return redirect('/')->with('error', 'View not defined for your role in Mata Kuliah.');
        }

        return view($viewName, $viewData);
    }

    public function store(StoreMataKuliahRequest $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $validatedData = $request->validated();
        $userInfo = $this->getUserFacultyProdiInfo($user);

        try {
            $validatedData['user_id'] = $user->id; // Track who created it

            if ($role === 'fakultas') {
                if (!$userInfo['faculty_code']) {
                    return redirect()->back()->with('error', 'Fakultas tidak teridentifikasi untuk akun Anda.')->withInput();
                }
                $validatedData['fakultas'] = $userInfo['faculty_code'];
                // 'prodi' comes from the form, can be null or a selected prodi under this faculty
                if (empty($validatedData['prodi'])) {
                    $validatedData['prodi'] = null;
                }
            } elseif ($role === 'prodi') {
                if (!$userInfo['faculty_code'] || !$userInfo['prodi_name']) {
                    return redirect()->back()->with('error', 'Fakultas atau Program Studi tidak teridentifikasi.')->withInput();
                }
                $validatedData['fakultas'] = $userInfo['faculty_code'];
                $validatedData['prodi'] = $userInfo['prodi_name'];
            }
            // For admin_direktorat, fakultas and prodi come directly from the form.

            if ($request->hasFile('rps')) {
                $path = $request->file('rps')->store('rps_matakuliah', 'public'); // Changed folder name
                $validatedData['rps_path'] = $path;
            } else {
                // RPS is required on store by StoreMataKuliahRequest, so this else might not be hit
                // unless request rules change.
                return redirect()->back()->with('error', 'File RPS wajib diunggah.')->withInput();
            }

            MataKuliah::create($validatedData);

            return redirect()->route($this->getRoleBasedRouteName('index'))
                ->with('success', 'Mata Kuliah berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error storing Mata Kuliah: ' . $e->getMessage(), ['request_data' => $request->except('rps'), 'user_id' => $user->id]);
            return redirect()->back()
                ->with('error', 'Gagal menyimpan Mata Kuliah: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource. 
     * For AJAX calls to populate edit modals.
     */
    public function edit(MataKuliah $matakuliah) // Route model binding
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyProdiInfo($user);
        $isOwner = ($matakuliah->user_id === $user->id);

        // Authorization
        if ($role === 'fakultas') {
            if ($matakuliah->fakultas !== $userInfo['faculty_code'] && !$isOwner) {
                return response()->json(['error' => 'Unauthorized. Not your faculty or owner.'], 403);
            }
        } elseif ($role === 'prodi') {
            if (!(($matakuliah->fakultas === $userInfo['faculty_code'] && $matakuliah->prodi === $userInfo['prodi_name']) && $isOwner)) {
                return response()->json(['error' => 'Unauthorized. Not your prodi or owner.'], 403);
            }
        }
        // Admins can edit any.
        return response()->json($matakuliah);
    }

    public function update(StoreMataKuliahRequest $request, MataKuliah $matakuliah) // Route model binding
    {
        $user = Auth::user();
        $role = $user->role;
        $validatedData = $request->validated();
        $userInfo = $this->getUserFacultyProdiInfo($user);
        $isOwner = ($matakuliah->user_id === $user->id);

        // Authorization
        if ($role === 'fakultas') {
            if ($matakuliah->fakultas !== $userInfo['faculty_code'] && !$isOwner) {
                return redirect()->back()->with('error', 'Unauthorized to update. Not your faculty or owner.');
            }
            // Fakultas can change prodi within their faculty or set to null
            $validatedData['fakultas'] = $userInfo['faculty_code']; // Enforce faculty
            if ($request->has('prodi') && empty($validatedData['prodi'])) {
                $validatedData['prodi'] = null;
            }
        } elseif ($role === 'prodi') {
            if (!(($matakuliah->fakultas === $userInfo['faculty_code'] && $matakuliah->prodi === $userInfo['prodi_name']) && $isOwner)) {
                return redirect()->back()->with('error', 'Unauthorized to update. Not your prodi or owner.');
            }
            // Prodi cannot change their faculty or prodi
            $validatedData['fakultas'] = $userInfo['faculty_code'];
            $validatedData['prodi'] = $userInfo['prodi_name'];
        }
        // Admins can change anything validated.

        try {
            if ($request->hasFile('rps')) {
                // Delete old file if it exists
                if ($matakuliah->rps_path && Storage::disk('public')->exists($matakuliah->rps_path)) {
                    Storage::disk('public')->delete($matakuliah->rps_path);
                }
                $path = $request->file('rps')->store('rps_matakuliah', 'public'); // Changed folder name
                $validatedData['rps_path'] = $path;
            }

            $matakuliah->update($validatedData);

            $redirectRoute = $this->getRoleBasedRouteName('index');
            if ($request->ajax()) { // If called from an AJAX request (e.g., modal form)
                return response()->json(['success' => true, 'message' => 'Mata Kuliah berhasil diperbarui!']);
            }
            return redirect()->route($redirectRoute)->with('success', 'Mata Kuliah berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating Mata Kuliah ID ' . $matakuliah->id . ': ' . $e->getMessage(), ['request_data' => $request->except('rps'), 'user_id' => $user->id]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui Mata Kuliah: ' . $e->getMessage()]);
            }
            return redirect()->back()
                ->with('error', 'Gagal memperbarui Mata Kuliah: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Request $request, MataKuliah $matakuliah) // Route model binding
    {
        $user = Auth::user();
        $role = $user->role;
        $userInfo = $this->getUserFacultyProdiInfo($user);
        $isOwner = ($matakuliah->user_id === $user->id);

        // Authorization
        if ($role === 'fakultas') {
            if ($matakuliah->fakultas !== $userInfo['faculty_code'] && !$isOwner) {
                return redirect()->back()->with('error', 'Unauthorized to delete. Not your faculty or owner.');
            }
        } elseif ($role === 'prodi') {
            if (!(($matakuliah->fakultas === $userInfo['faculty_code'] && $matakuliah->prodi === $userInfo['prodi_name']) && $isOwner)) {
                return redirect()->back()->with('error', 'Unauthorized to delete. Not your prodi or owner.');
            }
        }
        // Admins can delete any.

        try {
            // Delete RPS file
            if ($matakuliah->rps_path && Storage::disk('public')->exists($matakuliah->rps_path)) {
                Storage::disk('public')->delete($matakuliah->rps_path);
            }

            $matakuliah->delete();

            $redirectRoute = $this->getRoleBasedRouteName('index');
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Mata Kuliah berhasil dihapus!']);
            }
            return redirect()->route($redirectRoute)->with('success', 'Mata Kuliah berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting Mata Kuliah ID ' . $matakuliah->id . ': ' . $e->getMessage(), ['user_id' => $user->id]);
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus Mata Kuliah: ' . $e->getMessage()]);
            }
            return redirect()->back()
                ->with('error', 'Gagal menghapus Mata Kuliah: ' . $e->getMessage());
        }
    }

    /**
     * Provides faculty and program data.
     */
    private function getFacultyProgramDataForView()
    {
        // This should be consistent with UserController and other controllers.
        // Ideally, fetch from a centralized config or service.
        // Keys (PASCASARJANA, FIP) are uppercase for consistency.
        // Values for 'fakultas' in DB/forms are lowercase (e.g., 'fmipa').
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

    

    public function matakuliahSustainabilityView()
    {
        return view('Pemeringkatan.matakuliahsustainability.matakuliahsustainability');
    }

    public function getSustainabilityData()
    {
        // Get distinct years from courses
        $years = MataKuliah::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $yearData = [];
        foreach ($years as $year) {
            // Get SDG distribution for each year
            $sdgCounts = MataKuliah::whereYear('created_at', $year)
                ->selectRaw('sdgs_group, COUNT(*) as count')
                ->groupBy('sdgs_group')
                ->get()
                ->keyBy('sdgs_group');

            $data = [];
            for ($i = 1; $i <= 17; $i++) {
                $sdg = "SDGs $i";
                $data[] = $sdgCounts->has($sdg) ? $sdgCounts[$sdg]->count : 0;
            }
            $yearData[$year] = $data;
        }

        // Get faculty data
        $faculties = array_keys($this->getFacultyProgramDataForView());
        $facultyData = [];
        foreach ($faculties as $faculty) {
            $sdgCounts = MataKuliah::where('fakultas', strtolower($faculty))
                ->selectRaw('sdgs_group, COUNT(*) as count')
                ->groupBy('sdgs_group')
                ->get()
                ->keyBy('sdgs_group');

            $data = [];
            for ($i = 1; $i <= 17; $i++) {
                $sdg = "SDGs $i";
                $data[] = $sdgCounts->has($sdg) ? $sdgCounts[$sdg]->count : 0;
            }
            $facultyData[$faculty] = $data;
        }

        return response()->json([
            'yearData' => $yearData,
            'facultyData' => $facultyData
        ]);
    }
}

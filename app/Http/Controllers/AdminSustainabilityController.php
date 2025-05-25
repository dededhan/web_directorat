<?php

namespace App\Http\Controllers;

use App\Models\Sustainability;
use App\Models\SustainabilityPhoto;
use App\Http\Requests\StoreSustainabilityRequest;
// If you have an UpdateSustainabilityRequest, use it. Otherwise, validation is inline.
// use App\Http\Requests\UpdateSustainabilityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Added
use Illuminate\Support\Facades\Log; // Added

class AdminSustainabilityController extends Controller
{
    /**
     * Helper function to get faculty and prodi from user name.
     * Assumes faculty user name is like "FMIPA" and prodi user name is like "FMIPA-Ilmu Komputer".
     * Returns lowercase faculty and original case prodi.
     */
    private function getUserFacultyProdiInfo(User $user)
    {
        $userFaculty = null;
        $userProdi = null;
        $userFacultyKeyForData = null; // For accessing the programs list, usually uppercase

        if ($user->role === 'fakultas') {
            $userFaculty = strtolower($user->name); // e.g., "fmipa"
            $userFacultyKeyForData = strtoupper($user->name);
        } elseif ($user->role === 'prodi') {
            $parts = explode('-', $user->name, 2);
            if (count($parts) === 2) {
                $userFaculty = strtolower($parts[0]); // e.g., "fmipa"
                $userFacultyKeyForData = strtoupper($parts[0]);
                $userProdi = $parts[1];   // e.g., "Ilmu Komputer"
            } else {
                Log::warning('Unexpected name format for prodi user: ' . $user->name . ' ID: ' . $user->id);
                // Attempt to use the full name as faculty if format is wrong, though this is likely an error condition
                $userFaculty = strtolower($user->name);
                $userFacultyKeyForData = strtoupper($user->name);
            }
        }
        return ['faculty_code' => $userFaculty, 'prodi_name' => $userProdi, 'faculty_key' => $userFacultyKeyForData];
    }

    /**
     * Helper to get redirect route name based on user role and action.
     */
    private function getRoleBasedRouteName(string $actionSuffix, array $params = [])
    {
        $user = Auth::user();
        if (!$user) {
            return 'login'; // Or some default route if user is not authenticated
        }
        $role = $user->role;
        $baseRouteName = 'sustainability.' . $actionSuffix; // e.g., sustainability.index

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
                Log::warning('Trying to get role based route for unknown role or unhandled role: ' . $role);
                return 'dashboard'; // Fallback route
        }
    }


    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $sustainabilitiesQuery = Sustainability::with('photos')->latest();
        $userInfo = $this->getUserFacultyProdiInfo($user);

        if ($role === 'admin_direktorat' || $role === 'admin_pemeringkatan') {
            // Admins see all
            $sustainabilities = $sustainabilitiesQuery->paginate(10);
        } elseif ($role === 'fakultas') {
            if ($userInfo['faculty_code']) {
                // Fakultas sees all entries with their faculty code (their own and their prodis')
                $sustainabilitiesQuery->where('fakultas', $userInfo['faculty_code']);
            } else {
                Log::warning('Fakultas user has no faculty_code identified.', ['user_id' => $user->id, 'user_name' => $user->name]);
                $sustainabilitiesQuery->whereRaw('1 = 0'); // Return no results
            }
            $sustainabilities = $sustainabilitiesQuery->paginate(10);
        } elseif ($role === 'prodi') {
            if ($userInfo['faculty_code'] && $userInfo['prodi_name']) {
                // Prodi can only see their own entries
                $sustainabilitiesQuery->where('fakultas', $userInfo['faculty_code'])
                                      ->where('prodi', $userInfo['prodi_name']);
            } else {
                Log::warning('Prodi user has no faculty_code or prodi_name identified.', ['user_id' => $user->id, 'user_name' => $user->name]);
                $sustainabilitiesQuery->whereRaw('1 = 0'); // Return no results
            }
            $sustainabilities = $sustainabilitiesQuery->paginate(10);
        } else {
            Log::error('Unhandled role in Sustainability index: ' . $role, ['user_id' => $user->id]);
            return redirect('/')->with('error', 'Unauthorized access to sustainability index.');
        }

        $viewName = '';
        $viewData = ['sustainabilities' => $sustainabilities, 'user_info' => $userInfo];

        switch ($role) {
            case 'admin_direktorat':
                $viewName = 'admin.sustainability';
                // Admin might need full faculty/prodi lists for forms
                $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
                break;
            case 'prodi':
                $viewName = 'prodi.sustainability'; // Ensure this blade exists
                break;
            case 'fakultas':
                $viewName = 'fakultas.sustainability'; // Ensure this blade exists
                if ($userInfo['faculty_key']) {
                    $allFacultiesData = $this->getFacultyProgramDataForView();
                    $viewData['prodi_list_for_fakultas'] = $allFacultiesData[strtoupper($userInfo['faculty_key'])]['programs'] ?? [];
                } else {
                    $viewData['prodi_list_for_fakultas'] = [];
                }
                break;
            case 'admin_pemeringkatan':
                $viewName = 'admin_pemeringkatan.sustainability';
                 $viewData['faculties_data'] = $this->getFacultyProgramDataForView();
                break;
            default:
                return redirect('/')->with('error', 'View not defined for your role in sustainability.');
        }
        
        return view($viewName, $viewData);
    }
    
    public function store(StoreSustainabilityRequest $request)
    {
        $user = Auth::user();
        $role = $user->role;
        $validatedData = $request->validated(); // Retrieve validated data
        $userInfo = $this->getUserFacultyProdiInfo($user);

        try {
            // Add user_id to track who created it
            $validatedData['user_id'] = $user->id;

            if ($role === 'fakultas') {
                if (!$userInfo['faculty_code']) {
                    return redirect()->back()->with('error', 'Fakultas tidak teridentifikasi untuk akun Anda.')->withInput();
                }
                $validatedData['fakultas'] = $userInfo['faculty_code'];
                // 'prodi' comes from the form, can be null or a selected prodi under this faculty
                if (empty($validatedData['prodi'])) { // If "Fakultas Level" or empty selection
                    $validatedData['prodi'] = null;
                }
                // Further validation: ensure selected prodi (if any) belongs to $userInfo['faculty_code']
            } elseif ($role === 'prodi') {
                if (!$userInfo['faculty_code'] || !$userInfo['prodi_name']) {
                     return redirect()->back()->with('error', 'Fakultas atau Program Studi tidak teridentifikasi untuk akun Anda.')->withInput();
                }
                $validatedData['fakultas'] = $userInfo['faculty_code'];
                $validatedData['prodi'] = $userInfo['prodi_name'];
            }
            // For admin_direktorat, fakultas and prodi come directly from the form as per StoreSustainabilityRequest.

            $sustainability = Sustainability::create($validatedData);
            
            if ($request->hasFile('foto_kegiatan')) {
                $files = $request->file('foto_kegiatan'); // This can be an array if input name is foto_kegiatan[]
                if (!is_array($files)) {
                    $files = [$files]; // Ensure it's an array for consistent processing
                }

                foreach ($files as $file) {
                    if ($file->isValid()) {
                        $path = $file->store('sustainability', 'public');
                        SustainabilityPhoto::create([
                            'sustainability_id' => $sustainability->id,
                            'path' => $path
                        ]);
                    }
                }
            }

            return redirect()->route($this->getRoleBasedRouteName('index'))
                             ->with('success', 'Kegiatan berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error storing sustainability: ' . $e->getMessage() . ' for user role: ' . $role, ['request_data' => $request->all(), 'user_id' => $user->id]);
            return redirect()->back()
                ->with('error', 'Gagal menyimpan kegiatan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showPublic()
    {
        $sustainabilities = Sustainability::with('photos')->latest()->get();
        return view('galeri.sustainability', compact('sustainabilities'));
    }

    public function getSustainabilityDetail($id)
    {
        // Authorization: Admin can see all. Fakultas/Prodi should only see their own if this is for an edit modal.
        // For a generic detail API, it might be open or restricted. Assuming admin/owner access for now.
        $sustainability = Sustainability::with('photos')->findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'fakultas') {
            $userInfo = $this->getUserFacultyProdiInfo($user);
            if ($sustainability->fakultas !== $userInfo['faculty_code'] && $sustainability->user_id !== $user->id) { // Check ownership if not their direct faculty item
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } elseif ($user->role === 'prodi') {
            $userInfo = $this->getUserFacultyProdiInfo($user);
            if (($sustainability->fakultas !== $userInfo['faculty_code'] || $sustainability->prodi !== $userInfo['prodi_name']) && $sustainability->user_id !== $user->id) {
                 return response()->json(['error' => 'Unauthorized'], 403);
            }
        }
        // Admins can access any detail
        return response()->json($sustainability);
    }

    public function show(string $id) // For admin view if needed
    {
        $sustainability = Sustainability::with('photos')->findOrFail($id);
        // Add authorization if this view is intended for specific roles
        return view('admin.sustainability.show', compact('sustainability')); // Example path
    }

    public function update(Request $request, string $id) // Use UpdateSustainabilityRequest if available
    {
        $user = Auth::user();
        $role = $user->role;
        $sustainability = Sustainability::findOrFail($id);
        $userInfo = $this->getUserFacultyProdiInfo($user);

        // Authorization Check
        $isOwner = ($sustainability->user_id === $user->id); // Check if the current user created the entry

        if ($role === 'fakultas') {
            // Fakultas can edit items from their faculty, or items they specifically created (even if prodi is under them but created by prodi user)
            // Simplified: Can edit if item.fakultas matches user.fakultas OR if user is owner.
             if ($sustainability->fakultas !== $userInfo['faculty_code'] && !$isOwner) {
                return redirect()->back()->with('error', 'Unauthorized action. Not your faculty and you are not the owner.');
            }
        } elseif ($role === 'prodi') {
            // Prodi can only edit items they created AND that match their prodi/faculty assignment.
            if (!(($sustainability->fakultas === $userInfo['faculty_code'] && $sustainability->prodi === $userInfo['prodi_name']) && $isOwner)) {
                 return redirect()->back()->with('error', 'Unauthorized action. Not your prodi or you are not the owner.');
            }
        }
        // Admin_direktorat can update any.

        // Basic validation, replace with UpdateSustainabilityRequest if you have one.
        $validatedData = $request->validate([
            'judul_kegiatan' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'fakultas' => 'required|string|max:50', // Admin might change this
            'prodi' => 'nullable|string',          // Admin might change this, or fakultas for their prodis
            'link_kegiatan' => 'nullable|url|max:255',
            'deskripsi_kegiatan' => 'required|string',
            // Assuming foto_kegiatan in the form is for adding new photos, not replacing all.
            // If it's name="foto_kegiatan[]" for multiple files:
            'foto_kegiatan.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // If it's name="foto_kegiatan" for a single file (less likely with "multiple" in blade):
            // 'foto_kegiatan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
            
        try {
            if ($role === 'fakultas') {
                $validatedData['fakultas'] = $userInfo['faculty_code'];
                if ($request->has('prodi') && empty($validatedData['prodi'])) {
                    $validatedData['prodi'] = null;
                }
            } elseif ($role === 'prodi') {
                $validatedData['fakultas'] = $userInfo['faculty_code'];
                $validatedData['prodi'] = $userInfo['prodi_name'];
            }
            
            $sustainability->update($validatedData);
            
            if ($request->hasFile('foto_kegiatan')) {
                $files = $request->file('foto_kegiatan');
                if (!is_array($files)) {
                    $files = [$files];
                }
                foreach ($files as $file) {
                     if ($file->isValid()) {
                        $path = $file->store('sustainability', 'public');
                        SustainabilityPhoto::create([
                            'sustainability_id' => $sustainability->id,
                            'path' => $path
                        ]);
                    }
                }
            }
            
            $redirectRoute = $this->getRoleBasedRouteName('index');
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data kegiatan sustainability berhasil diperbarui!'
                ]);
            }
            return redirect()->route($redirectRoute)->with('success', 'Data kegiatan sustainability berhasil diperbarui!');
                
        } catch (\Exception $e) {
            Log::error('Error updating sustainability ID ' . $id . ': ' . $e->getMessage(), ['request_data' => $request->all(), 'user_id' => $user->id]);
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

    public function destroy(Request $request, string $id) // Added Request for AJAX check
    {
        $user = Auth::user();
        $role = $user->role;
        $sustainability = Sustainability::with('photos')->findOrFail($id);
        $userInfo = $this->getUserFacultyProdiInfo($user);
        $isOwner = ($sustainability->user_id === $user->id);

        // Authorization Check
        if ($role === 'fakultas') {
            if ($sustainability->fakultas !== $userInfo['faculty_code'] && !$isOwner) {
                 return redirect()->back()->with('error', 'Unauthorized action to delete.');
            }
        } elseif ($role === 'prodi') {
             if (!(($sustainability->fakultas === $userInfo['faculty_code'] && $sustainability->prodi === $userInfo['prodi_name']) && $isOwner)) {
                return redirect()->back()->with('error', 'Unauthorized action to delete.');
            }
        }
            
        try {
            foreach ($sustainability->photos as $photo) {
                Storage::disk('public')->delete($photo->path);
                $photo->delete();
            }
            
            $sustainability->delete();
            
            $redirectRoute = $this->getRoleBasedRouteName('index');
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Data kegiatan berhasil dihapus!']);
            }
            return redirect()->route($redirectRoute)->with('success', 'Data kegiatan sustainability berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting sustainability ID ' . $id . ': ' . $e->getMessage(), ['user_id' => $user->id]);
             if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menghapus data: ' . $e->getMessage()]);
            }
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }


    private function getFacultyProgramDataForView() {

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
}

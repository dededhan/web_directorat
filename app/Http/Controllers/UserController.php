<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest; // Pastikan ini diperbarui atau fleksibel untuk field 'name'
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Untuk transaksi DB
use Illuminate\Validation\Rule; // Untuk validasi kondisional jika diperlukan

class UserController extends Controller
{
    // Mendefinisikan data fakultas dan program studi (atau dapatkan dari config/service)
    private function getFacultiesAndProgramsData()
    {
        return [
            'PASCASARJANA' => [
                'name' => 'Pascasarjana',
                'programs' => [
                    'S3 Penelitian Dan Evaluasi Pendidikan', 
                    'S2 Penelitian Dan Evaluasi Pendidikan', 
                    'S2 Manajemen Lingkungan', 
                    'S3 Ilmu Manajemen', 
                    'S3 Manajemen Pendidikan', 
                    'S3 Pendidikan Dasar', 
                    'S2 Linguistik Terapan', 
                    'S3 Pendidikan Kependudukan Dan Lingkungan Hidup', 
                    'S2 Pendidikan Lingkungan', 
                    'S3 Pendidikan Jasmani', 
                    'S3 Teknologi Pendidikan', 
                    'S3 Linguistik Terapan', 
                    'S3 Pendidikan Anak Usia Dini', 
                    'S2 Manajemen Pendidikan Tinggi'
                ]
            ],
            'FIP' => [
                'name' => 'FIP (Fakultas Ilmu Pendidikan)',
                'programs' => [
                    'S2 Bimbingan Konseling', 
                    'S1 Bimbingan Dan Konseling', 
                    'S1 Pendidikan Luar Biasa', 
                    'S1 Manajemen Pendidikan', 
                    'S1 Pendidikan Masyarakat', 
                    'S1 Pendidikan Guru Pendidikan Anak Usia Dini', 
                    'S2 Pendidikan Dasar', 
                    'S2 Teknologi Pendidikan', 
                    'S1 Pendidikan Guru Sekolah Dasar', 
                    'S1 Teknologi Pendidikan', 
                    'S2 Pendidikan Masyarakat', 
                    'S2 Pendidikan Khusus', 
                    'S1 Perpustakaan dan Sains Informasi'
                ]
            ],
            'FMIPA' => [
                'name' => 'FMIPA (Fakultas Matematika dan Ilmu Pengetahuan Alam)',
                'programs' => [
                    'S1 Kimia', 
                    'S1 Statistika', 
                    'S1 Matematika', 
                    'S1 Pendidikan Matematika', 
                    'S1 Biologi', 
                    'S1 Ilmu Komputer', 
                    'S1 Fisika', 
                    'S2 Pendidikan Kimia', 
                    'S2 Pendidikan Biologi', 
                    'S2 Pendidikan Matematika', 
                    'S1 Pendidikan Biologi', 
                    'S1 Pendidikan Fisika', 
                    'S1 Pendidikan Kimia', 
                    'S2 Pendidikan Fisika'
                ]
            ],
            'FPPSI' => [
                'name' => 'FPPSI (Fakultas Psikologi)', // Disesuaikan berdasarkan prodi
                'programs' => [
                    'S1 Psikologi', 
                    'S2 Psikologi'
                ]
            ],
            'FBS' => [
                'name' => 'FBS (Fakultas Bahasa dan Seni)',
                'programs' => [
                    'S1 Pendidikan Musik', 
                    'S1 Pendidikan Tari', 
                    'S1 Pendidikan Seni Rupa', 
                    'S1 Pendidikan Bahasa Jepang', 
                    'S1 Sastra Indonesia', 
                    'S1 Pendidikan Bahasa Dan Sastra Indonesia', 
                    'S1 Pendidikan Bahasa Perancis', 
                    'S1 Sastra Inggris', 
                    'S1 Pendidikan Bahasa Jerman', 
                    'S1 Pendidikan Bahasa Inggris', 
                    'S2 Pendidikan Bahasa Inggris', 
                    'S1 Pendidikan Bahasa Arab', 
                    'S2 Pendidikan Bahasa Arab', 
                    'S1 Pendidikan Bahasa Mandarin', 
                    'S2 Pendidikan Seni'
                ]
            ],
            'FT' => [
                'name' => 'FT (Fakultas Teknik)',
                'programs' => [
                    'S1 Pendidikan Teknik Elektronika', 
                    'D4 Kosmetik dan Perawatan Kecantikan', 
                    'D4 Teknik Rekayasa Manufaktur', 
                    'D4 Seni Kuliner dan Pengolahan Jasa Makanan', 
                    'D4 Desain mode', 
                    'D4 Manajemen Pelabuhan dan Logistik Maritim', 
                    'S1 Pendidikan Teknik Informatika Dan Komputer', 
                    'S1 Pendidikan Tata Boga', 
                    'S1 Pendidikan Tata Busana', 
                    'S1 Pendidikan Tata Rias', 
                    'S1 Pendidikan Kesejahteraan Keluarga', 
                    'S2 Pendidikan Teknologi Dan Kejuruan', 
                    'S1 Pendidikan Teknik Bangunan', 
                    'S1 Pendidikan Teknik Elektro', 
                    'S1 Pendidikan Teknik Mesin', 
                    'D4 Teknik Rekayasa Otomasi', 
                    'D4 Teknologi Rekayasa Konstruksi Bangunan Gedung', 
                    'S1 Rekayasa Keselamatan Kebakaran', 
                    'S1 Teknik Mesin', 
                    'S1 Sistem dan Teknologi Informasi'
                ]
            ],
            'FIK' => [
                'name' => 'FIK (Fakultas Ilmu Keolahragaan)',
                'programs' => [
                    'S1 Ilmu Keolahragaan', 
                    'S1 Pendidikan Kepelatihan Olahraga', 
                    'S1 Pendidikan Jasmani, Kesehatan Dan Rekreasi', 
                    'S2 Pendidikan Jasmani', 
                    'S1 Kepelatihan Kecabangan Olahraga', 
                    'S1 Olahraga Rekreasi', 
                    'S2 Ilmu Keolahragaan'
                ]
            ],
            'FIS' => [
                'name' => 'FIS (Fakultas Ilmu Sosial)',
                'programs' => [
                    'D4 Usaha Perjalanan Wisata', 
                    'S1 Sosiologi', 
                    'S1 Pendidikan Agama Islam', 
                    'S1 Pendidikan Sosiologi', 
                    'S2 Pendidikan Sejarah', 
                    'D4 Hubungan Masyarakat dan Komunikasi Digital', 
                    'S1 Pendidikan Pancasila Dan Kewarganegaraan', 
                    'S1 Pendidikan Geografi', 
                    'S1 Pendidikan IPS', 
                    'S1 Pendidikan Sejarah', 
                    'S1 Ilmu Komunikasi (ILKOM)', 
                    'S1 Geografi', 
                    'S2 Pendidikan Geografi', 
                    'S2 Pendidikan Pancasila Dan Kewarganegaraan'
                ]
            ],
            'FE' => [
                'name' => 'FE (Fakultas Ekonomi)',
                'programs' => [
                    'D4 Akuntansi Sektor Publik', 
                    'D4 Administrasi Perkantoran Digital', 
                    'D4 Pemasaran Digital', 
                    'S1 Akuntansi', 
                    'S1 Manajemen', 
                    'S1 Pendidikan Ekonomi', 
                    'S2 Manajemen', 
                    'S1 Pendidikan Administrasi Perkantoran', 
                    'S1 Bisnis Digital', 
                    'S2 Akuntansi', 
                    'S1 Pendidikan Akuntansi', 
                    'S2 Pendidikan Ekonomi', 
                    'S1 Pendidikan Bisnis'
                ]
            ],
            'PROFESI' => [ // Menggunakan singkatan kapital untuk konsistensi kunci
                'name' => 'Program Profesi',
                'programs' => [
                    'Profesi PPG'
                ]
            ]
        ];
    }

    public function index()
    {
        $users = User::latest()->get();
        $facultiesAndProgramsData = $this->getFacultiesAndProgramsData();
        Log::info('Fetched users for manage page', ['count' => $users->count()]);
        return view('admin.manageuser', compact('users', 'facultiesAndProgramsData'));
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => ['required', 'string', Rule::in([
                'admin_direktorat', 'kepala_direktorat', 'admin_pemeringkatan', 
                'fakultas', 'prodi', 'admin_hilirisasi', 'kepala_sub_direktorat', 
                'wr3', 'dosen', 'mahasiswa', 'validator', 'registered_user'
            ])],
        ]);
        
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => $validated['role'],
                'status' => 'unactive', // Status default
            ]);

            // Logika untuk tabel spesifik peran (Dosen, Mahasiswa, Prodi, Fakultas)
            // jika Anda memiliki tabel tersebut dan perlu membuat entri di sana.
            // if ($user->role === 'prodi' && class_exists(\App\Models\Prodi::class)) {
            //     \App\Models\Prodi::create(['user_id' => $user->id, 'name' => $user->name, /* field prodi lainnya */]);
            // } else if ($user->role === 'fakultas' && class_exists(\App\Models\Fakultas::class)) {
            //     \App\Models\Fakultas::create(['user_id' => $user->id, 'name' => $user->name, /* field fakultas lainnya */]);
            // }
            // UsersSeeder.php Anda mengindikasikan adanya tabel seperti itu. Pastikan logika ini konsisten.


            DB::commit();
            Log::info('User created manually', ['user_id' => $user->id, 'role' => $user->role, 'name' => $user->name]);
            return redirect()->back()->with('success', 'User berhasil ditambahkan: ' . $user->name);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create user or role-specific record', [
                'role' => $validated['role'],
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString() // Tambahkan trace untuk debug lebih detail
            ]);
            return redirect()->back()->with('error', 'Gagal membuat data user: ' . $e->getMessage());
        }
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'status' => $user->status === 'active' ? 'unactive' : 'active'
        ]);
        return redirect()->back()->with('success', 'Status user berhasil diubah untuk: ' . $user->name);
    }

    public function update(Request $request, User $user) 
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', 
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'role' => ['required', 'string', Rule::in([
                'admin_direktorat', 'kepala_direktorat', 'admin_pemeringkatan', 
                'fakultas', 'prodi', 'admin_hilirisasi', 'kepala_sub_direktorat', 
                'wr3', 'dosen', 'mahasiswa', 'validator', 'registered_user'
            ])],
            'status' => ['required', 'string', Rule::in(['active', 'unactive'])],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        DB::beginTransaction();
        try {
            // $oldRole = $user->role; // Simpan role lama jika perlu logika khusus
            // $oldName = $user->name; // Simpan nama lama jika perlu logika khusus

            $user->update($updateData);

            // Logika pembaruan tabel spesifik peran jika peran atau nama yang relevan berubah.
            // Bagian ini bisa kompleks jika Anda perlu menghapus dari tabel peran lama dan menambah ke yang baru.
            // Untuk kesederhanaan, jika nama untuk prodi/fakultas berubah, Anda mungkin perlu memperbarui
            // nama di tabel Prodi/Fakultas yang sesuai jika tabel tersebut menyimpannya.
            // if (($oldRole !== $user->role || $oldName !== $user->name) && ($user->role === 'prodi' || $oldRole === 'prodi')) {
            //    // Perbarui atau kelola entri tabel Prodi
            // }
            // Logika serupa untuk tabel Fakultas

            DB::commit();
            Log::info('User updated', ['user_id' => $user->id, 'new_role' => $user->role, 'new_name' => $user->name]);
            return redirect()->route('admin.manageuser.index')->with('success', 'User berhasil diperbarui: ' . $user->name);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        Log::debug('Received delete request for user ID: ' . $id);
        $user = User::find($id);

        if (!$user) {
            Log::error('User tidak ditemukan untuk dihapus', ['user_id' => $id]);
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }
    
        DB::beginTransaction();
        try {
            $userName = $user->name; 
            // Sebelum menghapus user, Anda mungkin perlu menghapus record terkait
            // di tabel Dosen, Mahasiswa, Prodi, Fakultas jika ada dan memiliki foreign key.
            // Contoh:
            // if (method_exists($user, 'dosen') && $user->dosen) $user->dosen->delete();
            // if (method_exists($user, 'mahasiswa') && $user->mahasiswa) $user->mahasiswa->delete();
            // if (method_exists($user, 'prodiRel') && $user->prodiRel) $user->prodiRel->delete(); // Asumsi 'prodiRel' adalah nama relasi
            // if (method_exists($user, 'fakultasRel') && $user->fakultasRel) $user->fakultasRel->delete(); // Asumsi 'fakultasRel' adalah nama relasi

            // Ini tergantung pada bagaimana relasi model User Anda ke model Prodi/Fakultas diatur.
            // Jika Anda memiliki cascading deletes yang diatur di level database atau di model events,
            // ini mungkin ditangani secara otomatis. Jika tidak, Anda perlu melakukannya secara manual.

            $user->delete();
            DB::commit();
    
            Log::info('User deleted successfully', ['user_id' => $id, 'name' => $userName]);
            return redirect()->back()->with('success', 'User berhasil dihapus: ' . $userName);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete user', [
                'error' => $e->getMessage(), 
                'user_id' => $id
            ]);
            return redirect()->back()->with('error', 'Gagal menghapus user: '.$e->getMessage());
        }
    }
}

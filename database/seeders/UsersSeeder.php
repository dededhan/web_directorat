<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $existingUserdata = [
            [
                'name'=>'Direktorat',
                'email'=>'admindirektorat12345@gmail.com',
                'password'=>Hash::make('admin12345'),
                'role'=>'admin_direktorat',
                'status' => 'active',
            ],
            [
                'name'=>'kepala direktorat',
                'email'=>'headdir@gmail.com',
                'password'=>Hash::make('direktorat050505'),
                'role'=>'kepala_direktorat',
                'status' => 'active',
            ],
            [
                'name'=>'Admin Pemeringkatan',
                'email'=>'adminpemeringkatan@gmail.com',
                'password'=>Hash::make('pemeringkatan242424'),
                'role'=>'admin_pemeringkatan',
                'status' => 'active',
            ],
            [
                'name'=>'Admin Inovasi',
                'email'=>'adminhil123@gmail.com',
                'password'=>Hash::make('inovasi242424'),
                'role'=>'admin_hilirisasi',
                'status' => 'active',
            ],
            [
                'name'=>'Kepala Sub Dir',
                'email'=>'kepsub@gmail.com',
                'password'=>Hash::make('subdir12345'),
                'role'=>'kepala_sub_direktorat',
                'status' => 'active',
            ],
            [
                'name'=>'wakil rektor 3',
                'email'=>'wakilrektorat3@gmail.com',
                'password'=>Hash::make('wakilrek123'),
                'role'=>'wr3',
                'status' => 'active',
            ],
            [
                'name'=>'dosen ilkom',
                'email'=>'dosen123@gmail.com',
                'password'=>Hash::make('dosen123'),
                'role'=>'dosen',
                'status' => 'active',
            ],
            [
                'name'=>'team penilai',
                'email'=>'valid123@gmail.com',
                'password'=>Hash::make('valid123'),
                'role'=>'validator',
                'status' => 'active',
            ],
        ];

        foreach ($existingUserdata as $data) {
            $user = User::firstOrCreate(['email' => $data['email']], $data);

            // If you have Dosen or Mahasiswa models that need a corresponding record linked to the User:
            if ($user->wasRecentlyCreated) {
                if ($user->role === 'dosen' && class_exists(Dosen::class)) {
                    Dosen::firstOrCreate(['user_id' => $user->id], [
                        'name' => $user->name,
                    ]);
                } elseif ($user->role === 'mahasiswa' && class_exists(Mahasiswa::class)) {
                    Mahasiswa::firstOrCreate(['user_id' => $user->id], [
                        'name' => $user->name,
                    ]);
                }
            }
        }
        $facultiesAndProgramsData = $this->getFacultiesAndProgramsData();
        $commonFakultasPassword = Hash::make('fakultas123');
        $commonProdiPassword = Hash::make('prodi123');

        foreach ($facultiesAndProgramsData as $facultyAbbr => $facultyData) {
            // Create User record for Fakultas role
            $fakultasUserNameInUserTable = strtoupper($facultyAbbr);
            $fakultasUserEmail = strtolower($facultyAbbr) . '@unj.ac.id';

            User::firstOrCreate(
                ['email' => $fakultasUserEmail],
                [
                    'name' => $fakultasUserNameInUserTable,
                    'password' => $commonFakultasPassword,
                    'role' => 'fakultas',
                    'status' => 'active',
                ]
            );

            // Create User records for Prodi roles
            if (!empty($facultyData['programs'])) {
                foreach ($facultyData['programs'] as $prodiName) {
                    $sanitizedProdiNameForEmail = strtolower(Str::slug($prodiName, ''));
                    $prodiUserEmail = $sanitizedProdiNameForEmail . '@unj.ac.id';
                    $prodiUserNameInUserTable = $fakultasUserNameInUserTable . '-' . $prodiName;

                    User::firstOrCreate(
                        ['email' => $prodiUserEmail],
                        [
                            'name' => $prodiUserNameInUserTable,
                            'password' => $commonProdiPassword,
                            'role' => 'prodi',
                            'status' => 'active',
                        ]
                    );
                }
            }
        }
    }

    private function getFacultiesAndProgramsData() {
        return [
            'PASCASARJANA' => ['name' => 'Pascasarjana', 'programs' => ['S3 Penelitian Dan Evaluasi Pendidikan', 'S2 Penelitian Dan Evaluasi Pendidikan', 'S2 Manajemen Lingkungan', 'S3 Ilmu Manajemen', 'S3 Manajemen Pendidikan', 'S3 Pendidikan Dasar', 'S2 Linguistik Terapan', 'S3 Pendidikan Kependudukan Dan Lingkungan Hidup', 'S2 Pendidikan Lingkungan', 'S3 Pendidikan Jasmani', 'S3 Teknologi Pendidikan', 'S3 Linguistik Terapan', 'S3 Pendidikan Anak Usia Dini', 'S2 Manajemen Pendidikan Tinggi']],
            'FIP' => ['name' => 'FIP (Fakultas Ilmu Pendidikan)', 'programs' => ['S2 Bimbingan Konseling', 'S1 Bimbingan Dan Konseling', 'S1 Pendidikan Luar Biasa', 'S1 Manajemen Pendidikan', 'S1 Pendidikan Masyarakat', 'S1 Pendidikan Guru Pendidikan Anak Usia Dini', 'S2 Pendidikan Dasar', 'S2 Teknologi Pendidikan', 'S1 Pendidikan Guru Sekolah Dasar', 'S1 Teknologi Pendidikan', 'S2 Pendidikan Masyarakat', 'S2 Pendidikan Khusus', 'S1 Perpustakaan dan Sains Informasi']],
            'FMIPA' => ['name' => 'FMIPA (Fakultas Matematika dan Ilmu Pengetahuan Alam)', 'programs' => ['S1 Kimia', 'S1 Statistika', 'S1 Matematika', 'S1 Pendidikan Matematika', 'S1 Biologi', 'S1 Ilmu Komputer', 'S1 Fisika', 'S2 Pendidikan Kimia', 'S2 Pendidikan Biologi', 'S2 Pendidikan Matematika', 'S1 Pendidikan Biologi', 'S1 Pendidikan Fisika', 'S1 Pendidikan Kimia', 'S2 Pendidikan Fisika']],
            'FPPSI' => ['name' => 'FPPSI (Fakultas Psikologi)', 'programs' => ['S1 Psikologi', 'S2 Psikologi']],
            'FBS' => ['name' => 'FBS (Fakultas Bahasa dan Seni)', 'programs' => ['S1 Pendidikan Musik', 'S1 Pendidikan Tari', 'S1 Pendidikan Seni Rupa', 'S1 Pendidikan Bahasa Jepang', 'S1 Sastra Indonesia', 'S1 Pendidikan Bahasa Dan Sastra Indonesia', 'S1 Pendidikan Bahasa Perancis', 'S1 Sastra Inggris', 'S1 Pendidikan Bahasa Jerman', 'S1 Pendidikan Bahasa Inggris', 'S2 Pendidikan Bahasa Inggris', 'S1 Pendidikan Bahasa Arab', 'S2 Pendidikan Bahasa Arab', 'S1 Pendidikan Bahasa Mandarin', 'S2 Pendidikan Seni']],
            'FT' => ['name' => 'FT (Fakultas Teknik)', 'programs' => ['S1 Pendidikan Teknik Elektronika', 'D4 Kosmetik dan Perawatan Kecantikan', 'D4 Teknik Rekayasa Manufaktur', 'D4 Seni Kuliner dan Pengolahan Jasa Makanan', 'D4 Desain mode', 'D4 Manajemen Pelabuhan dan Logistik Maritim', 'S1 Pendidikan Teknik Informatika Dan Komputer', 'S1 Pendidikan Tata Boga', 'S1 Pendidikan Tata Busana', 'S1 Pendidikan Tata Rias', 'S1 Pendidikan Kesejahteraan Keluarga', 'S2 Pendidikan Teknologi Dan Kejuruan', 'S1 Pendidikan Teknik Bangunan', 'S1 Pendidikan Teknik Elektro', 'S1 Pendidikan Teknik Mesin', 'D4 Teknik Rekayasa Otomasi', 'D4 Teknologi Rekayasa Konstruksi Bangunan Gedung', 'S1 Rekayasa Keselamatan Kebakaran', 'S1 Teknik Mesin', 'S1 Sistem dan Teknologi Informasi']],
            'FIKK' => ['name' => 'FIKK (Fakultas Ilmu Keolahragaan)', 'programs' => ['S1 Ilmu Keolahragaan', 'S1 Pendidikan Kepelatihan Olahraga', 'S1 Pendidikan Jasmani, Kesehatan Dan Rekreasi', 'S2 Pendidikan Jasmani', 'S1 Kepelatihan Kecabangan Olahraga', 'S1 Olahraga Rekreasi', 'S2 Ilmu Keolahragaan']],
            'FIS' => ['name' => 'FIS (Fakultas Ilmu Sosial)', 'programs' => ['D4 Usaha Perjalanan Wisata', 'S1 Sosiologi', 'S1 Pendidikan Agama Islam', 'S1 Pendidikan Sosiologi', 'S2 Pendidikan Sejarah', 'D4 Hubungan Masyarakat dan Komunikasi Digital', 'S1 Pendidikan Pancasila Dan Kewarganegaraan', 'S1 Pendidikan Geografi', 'S1 Pendidikan IPS', 'S1 Pendidikan Sejarah', 'S1 Ilmu Komunikasi (ILKOM)', 'S1 Geografi', 'S2 Pendidikan Geografi', 'S2 Pendidikan Pancasila Dan Kewarganegaraan']],
            'FE' => ['name' => 'FE (Fakultas Ekonomi)', 'programs' => ['D4 Akuntansi Sektor Publik', 'D4 Administrasi Perkantoran Digital', 'D4 Pemasaran Digital', 'S1 Akuntansi', 'S1 Manajemen', 'S1 Pendidikan Ekonomi', 'S2 Manajemen', 'S1 Pendidikan Administrasi Perkantoran', 'S1 Bisnis Digital', 'S2 Akuntansi', 'S1 Pendidikan Akuntansi', 'S2 Pendidikan Ekonomi', 'S1 Pendidikan Bisnis']],
            'PROFESI' => ['name' => 'Program Profesi', 'programs' => ['Profesi PPG']]
        ];
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

           // Kosongkan tabel secara paksa
        DB::table('equity_prodi')->truncate();

        // Nyalakan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        
        $now = Carbon::now();

       DB::table('equity_prodi')->insert([
            // Pascasarjana (ID: 9)
            ['fakultas_id' => 9, 'name' => 'S3 Penelitian Dan Evaluasi Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S2 Penelitian Dan Evaluasi Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S2 Manajemen Lingkungan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Ilmu Manajemen', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Manajemen Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Pendidikan Dasar', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S2 Linguistik Terapan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Pendidikan Kependudukan Dan Lingkungan Hidup', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S2 Pendidikan Lingkungan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Pendidikan Jasmani', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Teknologi Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Linguistik Terapan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S3 Pendidikan Anak Usia Dini', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 9, 'name' => 'S2 Manajemen Pendidikan Tinggi', 'created_at' => $now, 'updated_at' => $now],

            // FIP (ID: 1)
            ['fakultas_id' => 1, 'name' => 'S2 Bimbingan Konseling', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Bimbingan Dan Konseling', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Pendidikan Luar Biasa', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Manajemen Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Pendidikan Masyarakat', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Pendidikan Guru Pendidikan Anak Usia Dini', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S2 Pendidikan Dasar', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S2 Teknologi Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Pendidikan Guru Sekolah Dasar', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Teknologi Pendidikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S2 Pendidikan Masyarakat', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S2 Pendidikan Khusus', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 1, 'name' => 'S1 Perpustakaan dan Sains Informasi', 'created_at' => $now, 'updated_at' => $now],
            
            // FMIPA (ID: 3)
            ['fakultas_id' => 3, 'name' => 'S1 Kimia', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Statistika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Matematika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Pendidikan Matematika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Biologi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Ilmu Komputer', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Fisika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S2 Pendidikan Kimia', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S2 Pendidikan Biologi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S2 Pendidikan Matematika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Pendidikan Biologi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Pendidikan Fisika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S1 Pendidikan Kimia', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 3, 'name' => 'S2 Pendidikan Fisika', 'created_at' => $now, 'updated_at' => $now],

            // FPPSI (ID: 8)
            ['fakultas_id' => 8, 'name' => 'S1 Psikologi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 8, 'name' => 'S2 Psikologi', 'created_at' => $now, 'updated_at' => $now],

            // FBS (ID: 2)
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Musik', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Tari', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Seni Rupa', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Jepang', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Sastra Indonesia', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Dan Sastra Indonesia', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Perancis', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Sastra Inggris', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Jerman', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Inggris', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S2 Pendidikan Bahasa Inggris', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Arab', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S2 Pendidikan Bahasa Arab', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S1 Pendidikan Bahasa Mandarin', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 2, 'name' => 'S2 Pendidikan Seni', 'created_at' => $now, 'updated_at' => $now],

            // FT (ID: 5)
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Teknik Elektronika', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Kosmetik dan Perawatan Kecantikan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Teknik Rekayasa Manufaktur', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Seni Kuliner dan Pengolahan Jasa Makanan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Desain mode', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Manajemen Pelabuhan dan Logistik Maritim', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Teknik Informatika Dan Komputer', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Tata Boga', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Tata Busana', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Tata Rias', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Kesejahteraan Keluarga', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S2 Pendidikan Teknologi Dan Kejuruan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Teknik Bangunan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Teknik Elektro', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Pendidikan Teknik Mesin', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Teknik Rekayasa Otomasi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'D4 Teknologi Rekayasa Konstruksi Bangunan Gedung', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Rekayasa Keselamatan Kebakaran', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Teknik Mesin', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 5, 'name' => 'S1 Sistem dan Teknologi Informasi', 'created_at' => $now, 'updated_at' => $now],

            // FIK (ID: 6)
            ['fakultas_id' => 6, 'name' => 'S1 Ilmu Keolahragaan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 6, 'name' => 'S1 Pendidikan Kepelatihan Olahraga', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 6, 'name' => 'S1 Pendidikan Jasmani, Kesehatan Dan Rekreasi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 6, 'name' => 'S2 Pendidikan Jasmani', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 6, 'name' => 'S1 Kepelatihan Kecabangan Olahraga', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 6, 'name' => 'S1 Olahraga Rekreasi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 6, 'name' => 'S2 Ilmu Keolahragaan', 'created_at' => $now, 'updated_at' => $now],

            // FIS (ID: 4)
            ['fakultas_id' => 4, 'name' => 'D4 Usaha Perjalanan Wisata', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Sosiologi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Pendidikan Agama Islam', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Pendidikan Sosiologi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S2 Pendidikan Sejarah', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'D4 Hubungan Masyarakat dan Komunikasi Digital', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Pendidikan Pancasila Dan Kewarganegaraan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Pendidikan Geografi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Pendidikan IPS', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Pendidikan Sejarah', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Ilmu Komunikasi (ILKOM)', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Geografi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S2 Pendidikan Geografi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S2 Pendidikan Pancasila Dan Kewarganegaraan', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 4, 'name' => 'S1 Ilmu Hukum', 'created_at' => $now, 'updated_at' => $now],
            

            // FE (ID: 7)
            ['fakultas_id' => 7, 'name' => 'D4 Akuntansi Sektor Publik', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'D4 Administrasi Perkantoran Digital', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'D4 Pemasaran Digital', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Akuntansi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Manajemen', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Pendidikan Ekonomi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S2 Manajemen', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Pendidikan Administrasi Perkantoran', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Bisnis Digital', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S2 Akuntansi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Pendidikan Akuntansi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S2 Pendidikan Ekonomi', 'created_at' => $now, 'updated_at' => $now],
            ['fakultas_id' => 7, 'name' => 'S1 Pendidikan Bisnis', 'created_at' => $now, 'updated_at' => $now],

            // Profesi (ID: 10)
            ['fakultas_id' => 10, 'name' => 'Profesi PPG', 'created_at' => $now, 'updated_at' => $now],

        ]
        );
    }
}
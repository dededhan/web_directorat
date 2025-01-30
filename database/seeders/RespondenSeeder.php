<?php

namespace Database\Seeders;

use App\Models\Responden;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RespondenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Responden::insert([
            [
                'title' => 'Mrs',
                'fullname' => 'Fauziah Maryani',
                'jabatan' => 'Staf Kemendikdasmen',
                'instansi' => 'Direktorat SMK Kemendikdasmen',
                'email' => 'fauziah.yani@pusdatin.belajar.id',
                'phone_responden' => '08118802676',
                'nama_dosen_pengusul' => 'Linda Ika Mayasari',
                'phone_dosen' => '08111990666',
                'fakultas' => 'FIP',
                'category' => 'employer',
                'status' => 'belum di-email',
            ],
            [
                'title' => 'Mr',
                'fullname' => 'Yasir Riady',
                'jabatan' => 'Direktur Universitas Terbuka Medan',
                'instansi' => 'Universitas Terbuka',
                'email' => 'yasir.riady@gmail.com',
                'phone_responden' => '081808332512',
                'nama_dosen_pengusul' => 'Imas Wahyu Agustina',
                'phone_dosen' => '085691470709',
                'fakultas' => 'FBS',
                'category' => 'academic',
                'status' => 'belum di-email',
            ],
            [
                'title' => 'Mr',
                'fullname' => 'Dede Ramadan',
                'jabatan' => 'CEO',
                'instansi' => 'Universitas Negeri Jakarta',
                'email' => 'dede.ramadan@gmail.com',
                'phone_responden' => '081808332678',
                'nama_dosen_pengusul' => 'Imas Wahyu Agustina',
                'phone_dosen' => '085691470709',
                'fakultas' => 'ILKOM',
                'category' => 'academic',
                'status' => 'belum di-email',
            ],
        ]
    );
    }
}

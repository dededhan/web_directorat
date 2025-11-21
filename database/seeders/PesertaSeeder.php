<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SulitestPesertaProfile;
use Illuminate\Support\Facades\Hash;

class PesertaSeeder extends Seeder
{

    public function run(): void
    {

        $peserta = User::firstOrCreate(
            ['email' => 'peserta@unj.ac.id'],
            [
                'name' => 'Peserta Uji Coba',
                'password' => Hash::make('password123'),
                'role' => 'sulitest_user',
                'status' => 'active',
            ]
        );

        SulitestPesertaProfile::firstOrCreate(
            ['user_id' => $peserta->id],
            [
                'nim' => '1234567890',
                'fakultas_id' => 1, // FIP
                'prodi_id' => 17, // S1 Bimbingan Dan Konseling
            ]
        );

        if ($peserta->wasRecentlyCreated) {
            $peserta->assignRole('sulitest_user');
            $this->command->info('Akun peserta uji coba berhasil dibuat.');
        } else {
            $peserta->assignRole('sulitest_user');
            $this->command->info('Akun peserta uji coba sudah ada, role dipastikan.');
        }
    }
}

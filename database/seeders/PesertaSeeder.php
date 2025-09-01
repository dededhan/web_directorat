<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PesertaSeeder extends Seeder
{

    public function run(): void
    {

        $peserta = User::firstOrCreate(
            [
                'email' => 'peserta@unj.ac.id'
            ],
            [
                'name' => 'Peserta Uji Coba',
                'password' => Hash::make('password123'),
                'role' => 'sulitest_user',
                'status' => 'active',
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

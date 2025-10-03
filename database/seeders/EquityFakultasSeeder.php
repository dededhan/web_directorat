<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Fakultas;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EquityFakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $fakultas = Fakultas::all();

        foreach ($fakultas as $fak) {

            $email = Str::slug($fak->abbreviation, '_') . '@equity.unj.ac.id';

            $user = User::updateOrCreate(
                [
                    'email' => $email
                ],
                [
                    'name' => 'Equity Fakultas ' . $fak->name,
                    'password' => Hash::make($email),
                    'role' => 'equity_fakultas',
                    'status' => 'active',
                ]
            );


            UserProfile::updateOrCreate(
                [
                    'user_id' => $user->id
                ],
                [
                    'fakultas_id' => $fak->id,
                    'prodi_id' => null,
                    'identifier_number' => null,
                ]
            );

            $this->command->info('Akun untuk ' . $fak->name . ' berhasil dibuat/diperbarui.');
        }
    }
}


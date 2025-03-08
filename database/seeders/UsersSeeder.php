<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $userdata = [
            [
                'name'=>'Admin Direktorat',
                'email'=>'admind123@gmail.com',
                'password'=>bcrypt('admin123'),
                'role'=>'admin_direktorat'
            ],
            [
                'name'=>'kepala direktorat',
                'email'=>'headdir@gmail.com',
                'password'=>bcrypt('direk123'),
                'role'=>'kepala_direktorat'
            ],
            [
                'name'=>'Admin Pemeringkatan',
                'email'=>'adminpemeringkatan@gmail.com',
                'password'=>bcrypt('admin123'),
                'role'=>'admin_pemeringkatan'
            ],
            [
                'name'=>'fakultas FMIPA',
                'email'=>'fakultasfmipa@gmail.com',
                'password'=>bcrypt('fakul123'),
                'role'=>'fakultas'
            ],
            [
                'name'=>'prodi ilkom',
                'email'=>'prodi@gmail.com',
                'password'=>bcrypt('prodi123'),
                'role'=>'prodi'
            ],
            [
                'name'=>'Admin hilirisasi',
                'email'=>'adminhil123@gmail.com',
                'password'=>bcrypt('admin123'),
                'role'=>'admin_hilirisasi'
            ],
            [
                'name'=>'kepala sub direktorat',
                'email'=>'admin123@gmail.com',
                'password'=>bcrypt('subdir123'),
                'role'=>'kepala_sub_direktorat'
            ],
            [
                'name'=>'wakil rektor 3',
                'email'=>'wakilrektorat3@gmail.com',
                'password'=>bcrypt('wakilrek123'),
                'role'=>'wr3'
            ],
            [
                'name'=>'dosen ilkom',
                'email'=>'dosen123@gmail.com',
                'password'=>bcrypt('dosen123'),
                'role'=>'dosen'
                
            ],
            [
                'name'=>'team penilai',
                'email'=>'valid123@gmail.com',
                'password'=>bcrypt('valid123'),
                'role'=>'validator'
                
            ],
        ];
        foreach ($userdata as $data) {
            $user = User::create($data);
            
            switch ($data['role']) {
                case 'dosen':
                    Dosen::create([ // PERBAIKI SINTAKS DISINI
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => $user->password
                    ]);
                    break;
                case 'mahasiswa':
                    Mahasiswa::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => $user->password                        
                    ]);
                    break;
                case 'prodi':
                        Prodi::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => $user->password                        
                    ]);
                    break;
                case 'fakultas':
                        Fakultas::create([
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => $user->password                        
                    ]);
                    break;

            }
        }
        // User::insert($userdata);
        // User::factory()->count(20)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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


            
        ];

        foreach($userdata as $key => $val){
            User::create($val);
        }
    }
}

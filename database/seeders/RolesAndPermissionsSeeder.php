<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        //ca
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate(['name' => 'manage sulitest']);
        Permission::firstOrCreate(['name' => 'take sulitest']);

        // role
        $adminRole = Role::firstOrCreate(['name' => 'admin_pemeringkatan']);
        $adminRole->givePermissionTo('manage sulitest');

        $participantRole = Role::firstOrCreate(['name' => 'sulitest_user']);
        $participantRole->givePermissionTo('take sulitest');
    }
}
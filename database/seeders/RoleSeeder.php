<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'admin_pencairan',
            'approver',
            'kepala_biro',
            'penerima',
            'pembukuan',
            'keuangan_arsip',
            'yayasan_arsip',
            'admin_it',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }
    }
}


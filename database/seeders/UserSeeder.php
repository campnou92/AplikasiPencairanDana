<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('Password123!');

        $users = [
            [
                'username' => 'admin_it',
                'nama' => 'Administrator IT',
                'email' => 'admin_it@instiper.ac.id',
                'role' => 'admin_it',
                'status' => 'aktif',
            ],
            [
                'username' => 'admin_pencairan',
                'nama' => 'Mba Ririn (Admin Pencairan)',
                'email' => 'ririn@instiper.ac.id',
                'role' => 'admin_pencairan',
                'status' => 'aktif',
            ],
            [
                'username' => 'approver',
                'nama' => 'Bu Fitri (Approver Keuangan)',
                'email' => 'fitri@instiper.ac.id',
                'role' => 'approver',
                'status' => 'aktif',
            ],
            [
                'username' => 'kepala_biro',
                'nama' => 'Kepala Biro',
                'email' => 'kepala_biro@instiper.ac.id',
                'role' => 'kepala_biro',
                'status' => 'aktif',
            ],
            [
                'username' => 'penerima',
                'nama' => 'Budi Santoso (Penerima Dana)',
                'email' => 'budi@instiper.ac.id',
                'role' => 'penerima',
                'status' => 'aktif',
            ],
            [
                'username' => 'pembukuan',
                'nama' => 'Petugas Pembukuan',
                'email' => 'pembukuan@instiper.ac.id',
                'role' => 'pembukuan',
                'status' => 'aktif',
            ],
            [
                'username' => 'keuangan_arsip',
                'nama' => 'Petugas Arsip Keuangan',
                'email' => 'arsip_keuangan@instiper.ac.id',
                'role' => 'keuangan_arsip',
                'status' => 'aktif',
            ],
            [
                'username' => 'yayasan_arsip',
                'nama' => 'Petugas Arsip Yayasan',
                'email' => 'arsip_yayasan@instiper.ac.id',
                'role' => 'yayasan_arsip',
                'status' => 'aktif',
            ],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['username' => $data['username']],
                [
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'password' => $defaultPassword,
                    'role' => $data['role'],
                    'status' => $data['status'],
                ]
            );

            // Assign Spatie role
            $user->syncRoles([$data['role']]);
        }
    }
}


<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleTestSeeder extends Seeder
{
    public function run(): void
    {
        // Create test users for each role
        $users = [
            [
                'nik' => '1234567890123456',
                'nama_lengkap' => 'Admin Test',
                'nomor_telepon' => '081234567890',
                'username' => 'admin_test',
                'email' => 'admin@test.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nik' => '2345678901234567',
                'nama_lengkap' => 'Dinas Test',
                'nomor_telepon' => '082345678901',
                'username' => 'dinas_test',
                'email' => 'dinas@test.com',
                'password' => Hash::make('password123'),
                'role' => 'dinas',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nik' => '3456789012345678',
                'nama_lengkap' => 'Pemerintah Pusat Test',
                'nomor_telepon' => '083456789012',
                'username' => 'pemerintah_test',
                'email' => 'pemerintah@test.com',
                'password' => Hash::make('09p'),
                'role' => 'pemerintah_pusat',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nik' => '4567890123456789',
                'nama_lengkap' => 'Masyarakat Test',
                'nomor_telepon' => '084567890123',
                'username' => 'masyarakat_test',
                'email' => 'masyarakat@test.com',
                'password' => Hash::make('password123'),
                'role' => 'masyarakat',
                'email_verified_at' => now(),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('You can now test the role-based routes with these credentials:');
        $this->command->info('Admin: admin@test.com / password123');
        $this->command->info('Dinas: dinas@test.com / password123');
        $this->command->info('Pemerintah Pusat: pemerintah@test.com / password123');
        $this->command->info('Masyarakat: masyarakat@test.com / password123');
    }
} 
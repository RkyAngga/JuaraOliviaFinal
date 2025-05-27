<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create test user
        User::create([
            'nik' => '1111111111111111',
            'nama_lengkap' => 'Test User',
            'nomor_telepon' => '081111111111',
            'username' => 'test_user',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role' => 'masyarakat',
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Run RoleTestSeeder
        $this->call([
            RoleTestSeeder::class,
        ]);
    }
}

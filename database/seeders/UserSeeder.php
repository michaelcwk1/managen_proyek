<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Data User Default
        $userData = [
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password'), // Pastikan mengganti password default ini
        ];

        // Cek jika user sudah ada berdasarkan email
        $user = User::where('email', $userData['email'])->first();

        if (!$user) {
            // Buat user biasa
            $user = User::create($userData);

            // Pastikan role user sudah ada
            $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

            // Assign role user ke user
            $user->assignRole($userRole);

            $this->command->info('Regular user created successfully.');
        } else {
            $this->command->info('User already exists.');
        }
    }
}

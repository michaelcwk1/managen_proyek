<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Data Admin Default
        $adminData = [
            'name' => 'Admin',
            'email' => 'admixn@example.com',
            'password' => bcrypt('password'), // Pastikan mengganti password default ini
        ];

        // Cek jika admin sudah ada berdasarkan email
        $admin = User::where('email', $adminData['email'])->first();

        if (!$admin) {
            // Buat user admin
            $admin = User::create($adminData);

            // Pastikan role admin sudah ada
            $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

            // Assign role admin ke user
            $admin->assignRole($adminRole);

            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}

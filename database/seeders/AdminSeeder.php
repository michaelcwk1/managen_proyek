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
            'name' => 'Faris',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // Pastikan mengganti password default ini
        ];

        // Cek jika admin sudah ada berdasarkan email
        $admin = User::where('email', $adminData['email'])->first();

        if (!$admin) {
            $admin = User::create($adminData);
            $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
            $admin->assignRole($adminRole);

            $this->command->info('Admin user created successfully.');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}

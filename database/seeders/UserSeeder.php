<?php
 
 namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userData = [
            'name' => 'Michael christoper',
            'email' => 'user@example.com',
            'password' => bcrypt('password'), 
        ];
   
    

        $user = User::where('email', $userData['email'])->first();

        if (!$user) {
            $user = User::create($userData);

            $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

            $user->assignRole($userRole);

            $this->command->info('Regular user created successfully.');
        } else {
            $this->command->info('User already exists.');
        }
    }
}


<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Daftar permissions
        $permissions = [
            'view users',
            'add users',
            'edit users',
            'delete users',
            'view projects',
            'add projects',
            'edit projects',
            'delete projects',
            'view tasks',
            'add tasks',
            'edit tasks',
            'delete tasks',
            'approve submissions',
            'review submissions',
            'add submissions',
        ];

        // Buat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Buat roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Assign permissions ke admin
        $adminRole->syncPermissions($permissions);

        // Assign sebagian permissions ke user
        $userPermissions = [
            'view projects',
            'view tasks',
            'add submissions',
        ];
        $userRole->syncPermissions($userPermissions);

        $this->command->info('Roles and permissions seeded successfully.');
    }
}

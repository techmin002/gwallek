<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AdminAndSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        // $superAdminRole = Role::firstOrCreate(['name' => 'Admin']);
        // Get all permission names
        $superadminPermissions = Permission::pluck('name')->toArray();

        // Create Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'super@super.com'],
            [
                'name' => 'Super Admin',
                'access_type' => 'Super Admin',
                'password' => Hash::make('P@ssword'),
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole($superAdminRole);
        $superAdminRole->syncPermissions($superadminPermissions); // Assign all permissions
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'manage orders']);
        Permission::create(['name' => 'manage products']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(['manage orders', 'manage products']);
        $userRole->givePermissionTo(['manage orders']); // regular user only manages their own orders
    }
}

<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // === Permissions ===
        $permissions = [
            // Dashboard
            ['name' => 'view dashboard'],

            // Rooms
            ['name' => 'view rooms'],
            ['name' => 'manage rooms'],

            // Customers
            ['name' => 'view customers'],
            ['name' => 'manage customers'],

            // Transactions
            ['name' => 'view transactions'],
            ['name' => 'manage transactions'],

            // Employees
            ['name' => 'view employees'],
            ['name' => 'manage employees'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']]);
        }

        // === Roles and Assign Permissions ===

        // Admin - All permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        // Manager
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->givePermissionTo([
            'view dashboard',
            'view rooms',
            'manage rooms',
            'view customers',
            'manage customers',
            'view transactions',
            'manage transactions',
        ]);

        // Receptionist
        $receptionist = Role::firstOrCreate(['name' => 'receptionist']);
        $receptionist->givePermissionTo([
            'view dashboard',
            'view rooms',
            'view customers',
            'view transactions',
        ]);

        // Staff
        $staff = Role::firstOrCreate(['name' => 'staff']);
        $staff->givePermissionTo([
            'view dashboard',
        ]);
    }
}

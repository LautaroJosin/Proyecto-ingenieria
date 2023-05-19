<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Roles list
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // role's permissions
        Permission::create(['name' => 'create dog'])->syncRoles('admin');
        Permission::create(['name' => 'delete dog'])->syncRoles('admin');
        Permission::create(['name' => 'edit dog'])->syncRoles('admin');
        Permission::create(['name' => 'show dog'])->syncRoles('admin');
        
        /*
         * To show role's permissions list, execute: 
         * php artisan permission:show
         */
    }
}

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

        // role's permissions for users
        Permission::create(['name' => 'create user'])->syncRoles('admin');
        
        // role's permissions for dogs
        Permission::create(['name' => 'create dog'])->syncRoles('admin');
        Permission::create(['name' => 'delete dog'])->syncRoles('admin');
        Permission::create(['name' => 'edit dog'])->syncRoles('admin');
        Permission::create(['name' => 'show dog'])->syncRoles('admin');

        // role's permissions for appointments
        Permission::create(['name' => 'create appointment'])->syncRoles('user');
        Permission::create(['name' => 'delete appointment'])->syncRoles('admin');
        Permission::create(['name' => 'edit appointment'])->syncRoles('admin');
        Permission::create(['name' => 'show appointment'])->syncRoles('user', 'admin');
		
        
		// role's permissions for adoption
		Permission::create(['name' => 'delete adoption dog'])->syncRoles('user');
		Permission::create(['name' => 'edit adoption dog'])->syncRoles('user');
		Permission::create(['name' => 'confirm adoption dog'])->syncRoles('user');

		
        /*
         * To show role's permissions list, execute: 
         * php artisan permission:show
         */
    }
}

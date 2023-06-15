<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    //To show role's permissions list, execute: php artisan permission:show
    
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        // Roles list
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // role's permissions for manage users
        Permission::create(['name' => 'create user'])->syncRoles('admin');
        
        // role's permissions for dogs
        Permission::create(['name' => 'create dog'])->syncRoles('admin');
        Permission::create(['name' => 'delete dog'])->syncRoles('admin');
        Permission::create(['name' => 'edit dog'])->syncRoles('admin');
        Permission::create(['name' => 'have dog'])->syncRoles('user');
        Permission::create(['name' => 'show dog'])->syncRoles('admin', 'user');

        // role's permissions for appointments
        Permission::create(['name' => 'create appointment'])->syncRoles('user');
        Permission::create(['name' => 'delete appointment'])->syncRoles('admin');
        Permission::create(['name' => 'edit appointment'])->syncRoles('admin');
        Permission::create(['name' => 'show appointment'])->syncRoles('user', 'admin');

        // role's permissions for treatments
        Permission::create(['name' => 'create treatment'])->syncRoles('admin');  
        
        // role's permissions for caregivers
        Permission::create(['name' => 'create caregiver'])->syncRoles('admin');
        Permission::create(['name' => 'delete caregiver'])->syncRoles('admin');
        Permission::create(['name' => 'edit caregiver'])->syncRoles('admin');
		 
		// role's permissions for adoption
		Permission::create(['name' => 'add adoption'])->syncRoles('user');
		Permission::create(['name' => 'delete adoption'])->syncRoles('user');
		Permission::create(['name' => 'edit adoption'])->syncRoles('user');
		Permission::create(['name' => 'confirm adoption'])->syncRoles('user');

        // role's permissions for lost dogs 
        Permission::create(['name' => 'manage lost dog'])->syncRoles('user');
        
        /*
         * To show role's permissions list, execute: 
         * php artisan permission:show
         */
    }
}

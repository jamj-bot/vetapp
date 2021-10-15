<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // role 1 = superadmin
        // role 2 = admin
        // role 3 = client
        // role 4 = veterinarian
        // role 5 = guest


        //------ VaccineDoses permissions ------
        Permission::create([
            'name' => 'vaccinations_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'vaccinations_destroy'
        ])->syncRoles(1);

        //------ Species permissions ------
        Permission::create([
            'name' => 'species_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'species_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'species_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'species_destroy'
        ])->syncRoles(1);


        //------ Users permissions ------
        Permission::create([
            'name' => 'users_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'users_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'users_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'users_destroy'
        ])->syncRoles(1);


        //------ Roles permissions ------
        Permission::create([
            'name' => 'roles_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'roles_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'roles_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'roles_destroy'
        ])->syncRoles(1);

        //------ Permissions permissions ------
        Permission::create([
            'name' => 'permissions_update'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'permissions_store'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'permissions_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'permissions_destroy'
        ])->syncRoles(1);

        //------ Assing permissions permissions ------
        Permission::create([
            'name' => 'assign_permissions_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'assign_permissions_sync'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'assign_permissions_revoke_all'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'assign_permissions_sync_all'
        ])->syncRoles(1);


        //------ Trash permissions ------
        Permission::create([
            'name' => 'trash_index'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'trash_restore'
        ])->syncRoles(1);
        Permission::create([
            'name' => 'trash_destroy'
        ])->syncRoles(1);

        //------ UserProfile permission ------
        Permission::create([
            'name' => 'user_profile_show'
        ])->syncRoles(1);
    }
}

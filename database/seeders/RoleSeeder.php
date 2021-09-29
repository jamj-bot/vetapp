<?php

namespace Database\Seeders;

use App\Policies\create;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Superadmin',
        ]);

        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Client',
        ]);
        Role::create([
            'name' => 'Veterinarian',
        ]);
        Role::create([
            'name' => 'Guest',
        ]);
    }
}

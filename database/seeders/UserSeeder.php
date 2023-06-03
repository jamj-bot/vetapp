<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Arturo Molina',
            'phone' => '3336897418',
            'email' => 'arturo@gmail.com',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Superadmin'
        ]);
        $user1->assignRole('Superadmin');

        $user2 = User::create([
            'name' => 'Jorge Arturo Molina Juárez',
            'phone' => '3345851719',
            'email' => 'jorgearturomolina@gmail.com',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Admin'
        ]);
        $user2->assignRole('Admin');

        $user3 = User::create([
            'name' => 'Pablo Donato Bernal',
            'phone' => '3345897845',
            'email' => 'padobemi@gmail.com',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Veterinarian'
        ]);
        $user3->assignRole('Veterinarian');

        Veterinarian::create([
            'user_id' => $user3->id,
            'dgp'     => '23808935'
        ]);

        $user4 = User::create([
            'name' => 'Luis Soto',
            'phone' => '3345659819',
            'email' => 'soto_rendon_luis@gdlzoo.org.mx',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Veterinarian'
        ]);
        $user4->assignRole('Veterinarian');

        Veterinarian::create([
            'user_id' => $user4->id,
            'dgp'     => '10813555'
        ]);

        $user5 = User::create([
            'name' => 'Maria Pérez',
            'phone' => '3645894517',
            'email' => 'mary_veterinaria@gmail.com',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Client'
        ]);
        $user5->assignRole('Client');

        $user6 = User::create([
            'name' => 'Paulina Hernández',
            'phone' => '3345581715',
            'email' => 'i_love_pau@terra.com.mx',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Client'
        ]);
        $user6->assignRole('Client');

        $user7 = User::create([
            'name' => 'Alfonso San Miguel',
            'phone' => '3314568987',
            'email' => 'a_san_miguiel@outlook.com',
            'password' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Client'
        ]);
        $user7->assignRole('Client');

        User::factory(0)->create();
    }
}

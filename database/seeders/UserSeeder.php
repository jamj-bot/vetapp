<?php

namespace Database\Seeders;

use App\Models\User;
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
            'confirmPassword' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Superadmin'
        ]);
        $user1->assignRole('Superadmin');

        $user2 = User::create([
            'name' => 'Jorge Arturo Molina Juárez',
            'phone' => '3345851719',
            'email' => 'jorgearturomolina@gmail.com',
            'password' => bcrypt('1234567890'),
            'confirmPassword' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Veterinarian'
        ]);
        $user2->assignRole('admin');

        $user3 = User::create([
            'name' => 'Pablo Donato Bernal Mizrahi',
            'phone' => '3345897845',
            'email' => 'padobemi@gmail.com',
            'password' => bcrypt('1234567890'),
            'confirmPassword' => bcrypt('1234567890'),
            'status' => 'active',
            'user_type' => 'Client'
        ]);
        $user3->assignRole('Client');

        User::factory(0)->create();
    }
}

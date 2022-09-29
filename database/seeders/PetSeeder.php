<?php

namespace Database\Seeders;

use App\Models\Pet;
use App\Models\Vaccination;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pet = Pet::create([
            'user_id'               => 3,
            'species_id'            => 2,
            'code'                  => '2045568978',
            'name'                  => 'Blanquita',
            'breed'                 => 'Criollo',
            'zootechnical_function' => 'Compañía',
            'sex'                   => 'Female',
            'dob'                   => '2020-06-10',
            'estimated'             => 1,
            'desexed'               => 'Not desexed',
            'desexing_candidate'    => 1,
            'alerts'                => null,
            'diseases'              => null,
            'allergies'             => null,
            'status'                => 'Alive',
        ]);

        $pet = Pet::create([
            'user_id'               => 3,
            'species_id'            => 3,
            'code'                  => '5689451210',
            'name'                  => 'TOPDOG L-135M',
            'breed'                 => 'Black angus',
            'zootechnical_function' => 'Semental',
            'sex'                   => 'Male',
            'dob'                   => '2018-02-10',
            'estimated'             => 0,
            'desexed'               => 'Not desexed',
            'desexing_candidate'    => 0,
            'alerts'                => null,
            'diseases'              => null,
            'allergies'             => null,
            'status'                => 'Alive',
        ]);

        $pet = Pet::create([
            'user_id'               => 1,
            'species_id'            => 1,
            'code'                  => '1689451219',
            'name'                  => 'Canela',
            'breed'                 => 'Criollo',
            'zootechnical_function' => 'Compañía',
            'sex'                   => 'Female',
            'dob'                   => '2033-05-19',
            'estimated'             => 0,
            'desexed'               => 'Not desexed',
            'desexing_candidate'    => 0,
            'alerts'                => null,
            'diseases'              => null,
            'allergies'             => null,
            'status'                => 'Alive',
        ]);

        Pet::factory(50)->create();
    }
}

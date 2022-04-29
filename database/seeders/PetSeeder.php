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
            'desexed'               => 'Not desexed',
            'desexing_candidate'    => 1,
            'alerts'                => null,
            'diseases'              => null,
            'allergies'             => null,
            'status'                => 'Alive',
        ]);

        Pet::factory(1)->create();
    }
}

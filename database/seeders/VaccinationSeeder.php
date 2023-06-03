<?php

namespace Database\Seeders;

use App\Models\Vaccination;
use Illuminate\Database\Seeder;

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vaccination::factory(40)->create();
    }
}

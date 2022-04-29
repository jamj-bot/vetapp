<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('public/profile-photos');
        Storage::makeDirectory('public/profile-photos');

        Storage::deleteDirectory('public/medical-imaging');
        Storage::makeDirectory('public/medical-imaging');

        Storage::deleteDirectory('public/tests');
        Storage::makeDirectory('public/tests');

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SpeciesSeeder::class);
        $this->call(PetSeeder::class);
        $this->call(VaccineSeeder::class);
        $this->call(VaccinationSeeder::class);
        $this->call(ParasiticideSeeder::class);
        $this->call(DewormingSeeder::class);
        $this->call(ConsultationSeeder::class);

    }
}

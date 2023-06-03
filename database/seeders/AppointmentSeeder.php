<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Appointment::factory(35)->create();
        // Appointment::factory()
        //     ->count(25)
        //     ->hasServiceBookeds(1)
        //     ->create();

        $appointments = Appointment::factory(0)->create();
        $services = Service::all();

        foreach ($appointments as $appointment) {
            $appointment->services()->attach($services->random(2));
        }
    }
}

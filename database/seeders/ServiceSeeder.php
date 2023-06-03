<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'service_name' => 'Examination',
            'duration'     => 10,
            'price'        => 250.00,
        ]);

        Service::create([
            'service_name' => 'Examination (cat)',
            'duration'     => 10,
            'price'        => 250.00,
        ]);

        Service::create([
            'service_name' => 'Examination (exotic animal)',
            'duration'     => 10,
            'price'        => 350.00,
        ]);

        Service::create([
            'service_name' => 'Vaccination',
            'duration'     => 10,
            'price'        => 30.00,
        ]);

        Service::create([
            'service_name' => 'Deworming',
            'duration'     => 10,
            'price'        => 20.00,
        ]);

        Service::create([
            'service_name' => 'Annual wellness exam',
            'duration'     => 10,
            'price'        => 150.00,
        ]);

        Service::create([
            'service_name' => 'Nail trim',
            'duration'     => 5,
            'price'        => 100.00,
        ]);

        Service::create([
            'service_name' => 'Anal gland expression',
            'duration'     => 5,
            'price'        => 190.00,
        ]);

        Service::create([
            'service_name' => 'Dermatology',
            'duration'     => 15,
            'price'        => 350.00,
        ]);

        Service::create([
            'service_name' => 'Ophthalmology',
            'duration'     => 15,
            'price'        => 350.00,
        ]);

        Service::create([
            'service_name' => 'Special procedure',
            'duration'     => 60,
            'price'        => 00.00,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Image;
use App\Models\Test;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consultations = Consultation::factory(25)->create();

        foreach ($consultations as $consultation) {
            Image::factory(random_int(0, 1))->create([
                'imageable_id' => $consultation->id,
                'imageable_type' => Consultation::class
            ]);

            Test::factory(random_int(0, 1))->create([
                'testable_id' => $consultation->id,
                'testable_type' => Consultation::class
            ]);
        }
    }
}

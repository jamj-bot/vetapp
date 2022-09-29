<?php

namespace Database\Seeders;

use App\Models\Consultation;
use App\Models\Disease;
use App\Models\Image;
use App\Models\Medicine;
use App\Models\Prescription;
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
        // $consultations = Consultation::factory(5)->create();

        $consultations = Consultation::factory(1)
            ->has(Disease::factory()->count(random_int(1, 2)))
            ->has(Prescription::factory()->count(1))
            ->create();


        // foreach ($consultations as $consultation) {
        //     Image::factory(random_int(0, 0))->create([
        //         'imageable_id' => $consultation->id,
        //         'imageable_type' => Consultation::class
        //     ]);

        //     Test::factory(random_int(0, 0))->create([
        //         'testable_id' => $consultation->id,
        //         'testable_type' => Consultation::class
        //     ]);

        //     Prescription::factory(1)->has(Medicine::factory()->count(random_int(3, 6))->has)
        //     ->create([
        //         'consultation_id' => $consultation->id
        //     ]);
        // }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;

class DiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Disease::create([
            'name' => 'Actinobacillosis',
        ]);

        Disease::create([
            'name' => 'Teschovirus Encephalomyelitis',
        ]);

        Disease::create([
            'name' => 'Polioencephalomalacia in Ruminants',
        ]);

        Disease::create([
            'name' => 'parvovirosis',
        ]);

        Disease::create([
            'name' => 'Fatty Liver Hemorrhagic Syndrome in Poultry',
        ]);

        Disease::create([
            'name' => 'Cestodes',
        ]);

        Disease::create([
            'name' => 'Oomycosis',
        ]);

        Disease::create([
            'name' => 'Mammary Tumors',
        ]);

        Disease::create([
            'name' => 'Ketonemia',
        ]);

        Disease::create([
            'name'=> 'Macadamia Nut Toxicosis',
        ]);

        Disease::create([
            'name'=> 'Canine Gallbladder Mucocele',
        ]);

        Disease::create([
            'name'=> 'Degenerative Arthropathy in Cattle',
        ]);

        Disease::create([
            'name'=> 'Transport Tetany in Ruminants',
        ]);

        Disease::create([
            'name'=> 'Lambliasis',
        ]);

        Disease::create([
            'name' => 'Feline Acromegaly',
        ]);

        Disease::create([
            'name' => 'Abomasal Ulcers in Cattle',
        ]);
    }
}


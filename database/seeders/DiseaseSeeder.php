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
            'name' => 'Distemper', // id: 1
        ]);

        Disease::create([
            'name' => 'Canine adenovirus type 1 (hepatitis)', // id: 2
        ]);

        Disease::create([
            'name' => 'Leptospirosis', // id: 3
        ]);

        Disease::create([
            'name' => 'Infectious respiratory disease', // id: 4
        ]);

       Disease::create([
            'name' => 'Parvovirosis', // id: 5
        ]);

        Disease::create([
            'name' => 'Rabies', // id: 6
        ]);

        Disease::create([
            'name' => 'Canine adenovirus type 2 (respiratory disease)', // id: 7
        ]);

       Disease::create([
            'name' => 'Canine parainfluenza', // id: 8
        ]);

        Disease::create([
            'name' => 'Encefalomielitis Aviar', // id: 9
        ]);

       Disease::create([
            'name' => 'Viruela Aviar', // id: 10
        ]);

        Disease::create([
            'name' => 'Clostridial diseases', // id: 11
        ]);

       Disease::create([
            'name' => 'Pneumonic pasteurellosis', // id: 12
        ]);

       Disease::create([
            'name' => 'Brucellosis', // id: 13
        ]);

        Disease::create([
            'name' => 'symptomatic smut', // id: 14
        ]);

       Disease::create([
            'name' => 'malignant edema', // id: 15
        ]);

        Disease::create([
            'name' => 'gas gangrene', // id: 16
        ]);

       Disease::create([
            'name' => 'infectious necrotic hepatitis pulpy kidney', // id: 17
        ]);

       Disease::create([
            'name' => 'enterotoxemia', // id: 18
        ]);

       Disease::create([
            'name' => 'infectious bovine rhinotracheitis ', // id: 19
        ]);

        Disease::create([
            'name' => 'bovine viral diarrhea', // id: 20
        ]);

       Disease::create([
            'name' => 'parainfluenza virus 3 ', // id: 21
        ]);

       Disease::create([
            'name' => 'bovine respiratory syncytial virus', // id: 22
        ]);

        Disease::create([
            'name' => 'Bordetella', // id: 23
        ]);

        Disease::create([
            'name' => 'Teschovirus Encephalomyelitis',
        ]);

        Disease::create([
            'name' => 'Polioencephalomalacia in Ruminants',
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


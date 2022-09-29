<?php

namespace Database\Seeders;

use App\Models\Species;
use Carbon\Traits\now;
use Illuminate\Database\Seeder;

class SpeciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Species::create([
            'name' => 'Perro',
            'scientific_name' => 'Cannis familiaris',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Gato',
            'scientific_name' => 'Felis catus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado Bovino',
            'scientific_name' => 'B. taurus - B. p. indicus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado Ovino',
            'scientific_name' => 'Ovis orientalis aries',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado Caprino',
            'scientific_name' => 'Capra aegagrus hircus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Conejo',
            'scientific_name' => 'Oryctolagus cuniculus',
            'deleted_at' => now()
        ]);

        Species::create([
            'name' => 'Caballo',
            'scientific_name' => 'Equus caballus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado porcino',
            'scientific_name' => 'Sus scrofa domesticus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado bufalino',
            'scientific_name' => 'Bubalus bubalis',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Avestruz',
            'scientific_name' => 'Struthio camelus',
            'deleted_at' => null
        ]);
    }
}

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
            'scientific_name' => 'Cannis Familiaris',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Gato',
            'scientific_name' => 'Felis catus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado Vacuno',
            'scientific_name' => 'Bos taurus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado Cebú',
            'scientific_name' => 'Bos taurus indicus',
            'deleted_at' => null
        ]);

        Species::create([
            'name' => 'Ganado Caprino',
            'scientific_name' => 'Capra aegagrus hircus',
            'deleted_at' => now()
        ]);
    }
}

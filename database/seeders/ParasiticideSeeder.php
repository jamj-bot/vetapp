<?php

namespace Database\Seeders;

use App\Models\Parasiticide;
use Illuminate\Database\Seeder;

class ParasiticideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parasiticide = Parasiticide::create([
            'name'                   => 'HALOCUR®',
            'type'                   => 'Internal',
            'manufacturer'           => 'MSD',
            'description'            => 'Para el tratamiento y prevención de la diarrea provocada por Cryptosporidium parvum.',
            'dose'                   => 'Ver instructivo del producto',
            'administration'         => 'Oral',
            'primary_application'    => 'Edad +10 días.',
            'primary_doses'          => 4,
            'reapplication_interval' => 'No reaplicar en adultos.',
            'reapplication_doses'    => 4,
        ]);

        // Uso la relación para definir a qué especies está relacionada la vacuna
        $parasiticide->species()->attach([3]);

        $parasiticide = Parasiticide::create([
            'name'                   => 'Granofen®',
            'type'                   => 'Internal',
            'manufacturer'           => 'Virbac',
            'description'            => 'Kills fleas and ticks for up to one month on dogs and puppies.',
            'dose'                   => '1 pill (500 mg)',
            'administration'         => 'Oral',
            'primary_application'    => 'Age: [0, 12] weeks',
            'primary_doses'          => 1,
            'reapplication_interval' => '1 year',
            'reapplication_doses'    => 1,
        ]);

        // Uso la relación para definir a qué especies está relacionada la vacuna
        $parasiticide->species()->attach([1, 2]);

        $parasiticide = Parasiticide::create([
            'name'                   => 'Levacur® SC',
            'type'                   => 'Internal',
            'manufacturer'           => 'MSD',
            'description'            => 'Levacur SC 3 % is effective against mature and developing immature stages of the following levamisole susceptible major nematode worm species: Trichostrongylus spp.,Cooperia spp., Ostertagia spp. (except inhibited Ostertagia larvae in cattle), Haemonchus spp., Nematodirus spp., Bunostomum spp.,Oesophagostomum spp., Chabertia spp., Dictyocaulus spp. Levacur SC 3 % is not effective against Type II Winter scour.',
            'dose'                   => '30 ml',
            'administration'         => 'Oral',
            'primary_application'    => 'Age: all ages',
            'primary_doses'          => 3,
            'reapplication_interval' => '6 months',
            'reapplication_doses'    => 1,
        ]);

        // Uso la relación para definir a qué especies está relacionada la vacuna
        $parasiticide->species()->attach([3, 4]);

        $parasiticide = Parasiticide::create([
            'name'                   => 'Bovilis® Huskvac',
            'type'                   => 'Internal',
            'manufacturer'           => 'MSD',
            'description'            => 'Bovilis Huskvac is an oral vaccination to help protect young and adult cattle against Lungworm or ‘Husk’ caused by Dictyocaulus viviparus.',
            'dose'                   => '25 ml',
            'administration'         => 'Oral',
            'primary_application'    => 'Age: all ages',
            'primary_doses'          => 1,
            'reapplication_interval' => '4 months',
            'reapplication_doses'    => 1,
        ]);

        // Uso la relación para definir a qué especies está relacionada la vacuna
        $parasiticide->species()->attach([3]);

        $parasiticide = Parasiticide::create([
            'name'                   => 'Panacur®',
            'type'                   => 'Internal',
            'manufacturer'           => 'MSD',
            'description'            => 'Adult dogs and cats: For the treatment of adult dogs and cats infected with gastro-intestinal nematodes and cestodes: (1) Ascarid spp —Toxocara canis, Toxocara cati and Toxascaris leonina—, (2) Ancylostoma spp, (3) Trichuris spp., (4) Uncinaria spp, (5) Taenia spp.',
            'dose'                   => '15 grams',
            'administration'         => 'Oral',
            'primary_application'    => 'Age: all ages',
            'primary_doses'          => 1,
            'reapplication_interval' => '6 months',
            'reapplication_doses'    => 1,
        ]);

        // Uso la relación para definir a qué especies está relacionada la vacuna
        $parasiticide->species()->attach([1, 2]);

    }
}

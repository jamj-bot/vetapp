<?php

namespace Database\Factories;

use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(
                [
                    'Amoxicillin',
                    'Haloperidol',
                    'Tramadol',
                    'Lactulose',
                    'Sodium picosulfate',
                    'Dexamethasone',
                    'Dypirone',
                    'Morphine',
                    'Metoclopramide',
                    'Macrogol',
                    'Amytiptyline',
                    'Rofecobxib',
                    'Diclofenac',
                    'Inipenem',
                    'Vancomycin',
                    'Linezolid'
                ]),
            'strength' => $this->faker->randomElement(
                [
                    '500 mg',
                    '250 mg/5 mL',
                    '12.5 mg',
                    '250 mg/vial',
                    '60 mg/vial',
                    '75 mgc'
               ]),
            'dosage_form' => $this->faker->randomElement(
                [
                    'Tablets',
                    'Capsules',
                    'Emulsion',
                    'Eye drops',
                    'Vaporizer',
                    'Injection',
                    'Gel',
                    'Spray'
                ])
            // 'quantity'     => $this->faker->numberBetween(1,50),
            // 'instructions' => $this->faker->sentence()
        ];
    }
}

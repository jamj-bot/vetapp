<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Vaccine;
use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccinationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vaccination::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pet_id'      => Pet::all()->random()->id,
            'vaccine_id'  => Vaccine::all()->random()->id,
            'type' => $this->faker->randomElement(['Vaccination', 'Revaccination']),
            'batch_number' => $this->faker->ssn(),
            'dose_number' => $this->faker->randomElement([1, 2, 3]),
            'doses_required' => $this->faker->randomElement([1, 2, 3]),
            'done' => $this->faker->randomElement([$this->faker->dateTimeBetween('2018-01-01', '2021-01-01')]),
            'applied'     => $this->faker->boolean(),

            //'next'        => $this->faker->dateTimeBetween('2021-02-02', '2021-12-12'),
            //'last_dose' => $this->faker->boolean(),
            // 'next_vaccine_applied' => $this->faker->boolean(),
        ];
    }
}

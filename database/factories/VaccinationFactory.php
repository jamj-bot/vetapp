<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Vaccine;
use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

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
        $done = $this->faker->randomElement([$this->faker->dateTimeBetween('-4 years', '+1 years')]);

        return [
            'pet_id'         => Pet::all()->random()->id,
            'vaccine_id'     => Vaccine::all()->random()->id,
            'type'           => $this->faker->randomElement(['Vaccination', 'Revaccination']),
            'batch_number'   => $this->faker->ssn(),
            'dose_number'    => $this->faker->randomElement([1, 2, 3]),
            'doses_required' => $this->faker->randomElement([1, 2, 3]),
            'done'           => $done,
            'applied'        => $this->faker->optional($weight = 0.95, $default = 1)->boolean, // 95% chance of 1
            //'applied'        => $this->faker->boolean(),
        ];
    }
}

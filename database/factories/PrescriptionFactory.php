<?php

namespace Database\Factories;

use App\Models\Prescription;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrescriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Prescription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order'                    => $this->faker->unique()->numerify('##########'),
            'date'                     => $this->faker->dateTimeBetween('-2 years', now()),
            'expiry'                   => $this->faker->dateTimeBetween('-2 years', now()),
            'repeat'                   => $this->faker->boolean(10),
            'number_of_repeats'        => $this->faker->numberBetween(1, 3),
            'interval_between_repeats' => $this->faker->randomElement(['1 month', '3 months', '2 months']),
            'further_information'      => $this->faker->paragraphs($nb = 2, $asText = true),
            'voided'                   => $this->faker->boolean(5),
        ];
    }
}

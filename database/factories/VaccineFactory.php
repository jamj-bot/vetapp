<?php

namespace Database\Factories;

use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Factories\Factory;

class VaccineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vaccine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                   => $this->faker->word,
            'type'                   => $this->faker->word,
            'manufacturer'           => $this->faker->word,
            'description'            => $this->faker->sentence,
            'status'                 => $this->faker->randomElement(['Required', 'Recommended', 'Optional']),
            'dosage'                 => $this->faker->word,
            'administration'         => $this->faker->sentence,
            'vaccination_schedule'   => $this->faker->sentence,
            'primary_doses'          => $this->faker->randomElement([1, 2, 3]),
            'revaccination_schedule' => $this->faker->sentence,
            'revaccination_doses'    => $this->faker->randomElement([1, 2, 3]);
        ];
    }
}

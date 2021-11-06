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
            'target_species'         => $this->faker->word,
            'name'                   => $this->faker->word,
            'type'                   => $this->faker->word,
            'manufacturer'           => $this->faker->word,
            'description'            => $this->faker->sentence,
            'dose'                   => $this->faker->word,
            'administration'         => $this->faker->sentence,
            'primary_vaccination'    => $this->faker->sentence,
            'primary_doses'          => $this->faker->randomElement([1, 2, 3]);,
            'revaccination_interval' => $this->faker->sentence,
            'revaccination_doses'    => $this->faker->randomElement([1, 2, 3]);
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Parasiticide;
use Illuminate\Database\Eloquent\Factories\Factory;

class ParasiticideFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Parasiticide::class;

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
            'dose'                   => $this->faker->word,
            'administration'         => $this->faker->word,
            'primary_application'    => $this->faker->word,
            'primary_doses'          => $this->faker->randomElement([1, 2, 3]),
            'reapplication_interval' => $this->faker->word,
            'reapplication_doses'    => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}

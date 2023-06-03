<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Veterinarian;
use Illuminate\Database\Eloquent\Factories\Factory;

class VeterinarianFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Veterinarian::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $veterinarians = User::role('Veterinarian')->get();

        return [
            'user_id' => $veterinarians->random()->id,
            'dgp'     => $this->faker->numerify('########')
        ];
    }
}

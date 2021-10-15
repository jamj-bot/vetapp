<?php

namespace Database\Factories;

use App\Models\Pet;
use App\Models\Species;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::all()->random()->id,
            'species_id' => Species::all()->random()->id,
            'code'       => $this->faker->unique()->numerify('##########'),
            'name'       => $this->faker->firstName('male'|'female'),
            'breed'      => $this->faker->randomElement(['Weimaraner', 'Sardo Negro', 'Angus', 'Angora', null]),
            'zootechnical_function' => $this->faker->randomElement(['Beef Cattle', 'Dairy Cattle', 'Companion', 'Assistance', 'Farm']),
            'sex'        => $this->faker->randomElement(['Male', 'Female', 'Unknown']),
            'dob'        => $this->faker->dateTimeBetween('2010-01-01', '2021-01-01'),
            'neutered'   => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'diseases'   => $this->faker->sentence(),
            'allergies'  => $this->faker->text(50),
            'status'     => $this->faker->randomElement(['Alive', 'Dead']),
        ];
    }
}

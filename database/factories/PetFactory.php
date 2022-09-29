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

        $desexed = $this->faker->randomElement(['Desexed', 'Not desexed', 'Unknown']);

        if ($desexed = 'Desexed') {
            $desexing_candidate = 1;
        } else {
            $desexing_candidate = $this->faker->boolean();
        }

        return [
            'user_id'               => User::all()->random()->id,
            'species_id'            => Species::all()->random()->id,
            'code'                  => $this->faker->unique()->numerify('##########'),
            'name'                  => $this->faker->randomElement([$this->faker->firstName('male'|'female')]),
            //'name'                  => $this->faker->username(),
            'breed'                 => $this->faker->randomElement([
                                            'Weimaraner',
                                            'Black angus',
                                            'Yorkshire',
                                            'Piamontese',
                                            'Simental',
                                            'Brahaman',
                                            'Gyr',
                                            'Nelore',
                                            'Braford',
                                            'Brangus negro',
                                            'Brangus rojo',
                                            'Holstein',
                                            'Jersey',
                                            'Suizo americano',
                                            'Suizo europeo',
                                            'Chihuahua',
                                            'Poodle',
                                            null
                                        ]),
            'zootechnical_function' => $this->faker->randomElement(['Beef Cattle', 'Dairy Cattle', 'Dual-purpose', 'Companion', null]),
            'sex'                   => $this->faker->randomElement(['Male', 'Female', 'Unknown']),
            'dob'                   => $this->faker->dateTimeBetween('2010-01-01', '2021-01-01'),
            'estimated'             => $this->faker->boolean(10),
            'desexed'               => $desexed,
            'desexing_candidate'    => $desexing_candidate,
            'alerts'                => $this->faker->randomElement([$this->faker->text(50), null]),
            'diseases'              => $this->faker->randomElement([$this->faker->text(50), null, null]),
            'allergies'             => $this->faker->randomElement([$this->faker->text(50), null, null, null]),
            'status'                => $this->faker->randomElement(['Alive', 'Dead']),
        ];
    }
}

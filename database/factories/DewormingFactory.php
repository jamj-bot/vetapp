<?php

namespace Database\Factories;

use App\Models\Deworming;
use App\Models\Parasiticide;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class DewormingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Deworming::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pet_id'            => Pet::all()->random()->id,
            'parasiticide_id'   => Parasiticide::all()->random()->id,
            'type'              => $this->faker->randomElement(['First application', 'Reapplication']),
            'duration'          => $this->faker->randomElement(['6 months', '1 year', '3 years']),
            'Withdrawal_period' => $this->faker->randomElement(['Meat: zero days', 'Milk: 49 days + 8 milkings', 'Meat: 7 days', 'Meat: 30 days', 'Milk: 30 days', null, null, null]),
            'dose_number'       => $this->faker->randomElement([1, 2, 3]),
            'doses_required'    => $this->faker->randomElement([1, 2, 3])
        ];
    }
}

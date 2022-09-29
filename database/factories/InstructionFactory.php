<?php

namespace Database\Factories;

use App\Models\Instruction;
use App\Models\Medicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstructionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Instruction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(5,50),
            'indications_for_owner' => $this->faker->sentence()
        ];
    }
}

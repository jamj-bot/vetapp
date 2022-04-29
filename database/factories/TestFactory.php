<?php

namespace Database\Factories;

use App\Models\Test;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Test::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => 'tests/' . $this->faker->image('public/storage/tests', 720, 1280, null, false),
            'name' => $this->faker->sentence(),
            'extension' => $this->faker->randomElement(['xlsx', 'docx', 'xls', 'doc', 'txt'])
        ];
    }
}

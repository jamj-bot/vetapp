<?php

namespace Database\Factories;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $veterinarians = User::role('Veterinarian')->get();

        //$day = dayOfWeek($max = 'now')                'Friday'
        //     'from'    => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+ 15 days', $timezone = null), DateTime('2003-03-15 02:00:49', 'Africa/Lagos'),
        //     'to'      => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '+ 15 days', $timezone = null) DateTime('2003-03-15 02:00:49', 'Africa/Lagos'),

        $entrada = $this->faker->dateTimeThisMonth($max = '+ 15 days', $timezone = null) ;

        return [
            'user_id' => $veterinarians->random()->id,
            'from'    => $this->faker->dateTimeThisMonth($max = '+ 15 days', $timezone = null), // DateTime('2003-03-15 02:00:49', 'Africa/Lagos'),
            'to'      => $this->faker->dateTimeBetween('2023-01-11 14:00:00', $endDate = '2023-01-11 14:00:01', $timezone = null) // DateTime('2003-03-15 02:00:49', 'Africa/Lagos'),
        ];
    }
}

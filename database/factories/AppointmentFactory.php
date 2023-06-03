<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Veterinarian;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $clients = User::role('client')->get();

        $start = Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-1 day', '+3 day')->getTimestamp());


        // $start = $this->faker->dateTimeThisMonth($max = '+ 15 days', $timezone = null);
        // $end = $start->addMinutes(61);

        return [
            'veterinarian_id' => Veterinarian::all()->random()->id,
            'user_id' => $clients->random()->id,
            'start_time' => $start->toDateTimeString(),
            'end_time_expected' => $start->addMinutes($this->faker->randomElement( [10, 20, 20, 60] )),
            //'price_expected' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1000), // 48.8932
            //'price_full' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 1500), // 48.8932
            'discount' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 250), // 48.8932
            'price_final' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 100, $max = 3000), // 48.8932
            'canceled' => $this->faker->boolean(),
            'cancellation_reason' => null,
        ];
    }
}

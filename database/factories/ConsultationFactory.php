<?php

namespace Database\Factories;

use App\Models\Consultation;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Consultation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $veterinarians = User::where('user_type', 'Veterinarian')->get();

        $diagnosis = $this->faker->optional($weight = 0.90, $default = null)->sentence; // 10% chance of null

        if ($diagnosis == null) {
            $consult_status = $this->faker->randomElement(['Lab tests pending', 'Radiology tests pending']);
        } else {
            $consult_status = 'Closed';
        }

        return [
            'user_id' => $veterinarians->random()->id,

            'pet_id' => Pet::all()->random()->id,

            'age' => $this->faker->randomElement(['7 days', '3 months', '1 year', '3 years', '9 years']),

            'weight' => $this->faker->randomFloat($nbMaxDecimals = 3, $min = 5, $max = 7),

            'temperature' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 34, $max = 42),

            'capillary_refill_time' =>
                $this->faker->randomElement(['Less than 1 second',
                    '1-2 seconds',
                    'Longer than 2 seconds'
                ]),

            'heart_rate' =>$this->faker->numberBetween($min = 50, $max = 250),

            'pulse' =>
                $this->faker->randomElement([
                    'Strong and synchronous with each heart beat',
                    'Irregular',
                    'Bounding',
                    'Weak or absent'
                ]),

            'respiratory_rate' => $this->faker->numberBetween($min = 0, $max = 100),

            'reproductive_status' =>
                $this->faker->randomElement([
                    'Pregnant',
                    'Lactating',
                    'Neither'
                ]),

            'consciousness'=>
                $this->faker->randomElement([
                    'Alert and responsive',
                    'Depressed or obtunded',
                    'Stupor',
                    'Comatose'
                ]),

            'hydration'=> $this->faker->randomElement(['Normal', '0-5%', '6-7%', '8-9%', '+10%']),

            'pain' =>
                $this->faker->randomElement([
                    'None',
                    'Vocalization',
                    'Changes in behavior',
                    'Physical changes'
                ]),

            'body_condition' => $this->faker->randomElement(['Too thin', 'Ideal', 'Too heavy']),

            'problem_statement' => $this->faker->paragraphs($nb = 10, $asText = true),

            'diagnosis' => $diagnosis,

            'prognosis' => $this->faker->randomElement(['Good', 'Fair', 'Guarded', 'Grave', 'Poor', 'Pending']),

            'treatment_plan' => $this->faker->paragraphs($nb = 5, $asText = true),

            'consult_status' => $consult_status
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 08:00:00',
            'to'              => '2023-01-10 14:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 15:00:00',
            'to'              => '2023-01-10 18:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-11 08:00:00',
            'to'              => '2023-01-11 14:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-11 15:00:00',
            'to'              => '2023-01-11 18:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-12 08:00:00',
            'to'              => '2023-01-12 14:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-12 15:00:00',
            'to'              => '2025-01-12 18:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 08:00:00',
            'to'              => '2023-01-10 14:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2025-01-10 15:00:00',
            'to'              => '2025-01-10 18:00:00'
        ]);



        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 08:00:00',
            'to'              => '2023-01-10 14:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 15:00:00',
            'to'              => '2023-01-10 18:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 08:00:00',
            'to'              => '2023-01-10 14:00:00'
        ]);

        Schedule::create([
            'veterinarian_id' => 1,
            'from'            => '2023-01-10 15:00:00',
            'to'              => '2023-01-10 18:00:00'
        ]);

        //Schedule::factory(40)->create();
    }
}

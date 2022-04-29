<?php

namespace Database\Seeders;

use App\Models\Deworming;
use Illuminate\Database\Seeder;

class DewormingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Deworming::factory(10)->create();
    }
}

<?php

use Illuminate\Database\Seeder;
use App\QuizPassingRate;

class PassingRates extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuizPassingRate::create([
            'course_id' => 1,
            'attempt' => 1,
            'score' => 75
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\QuizPassingRate;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::create([
            'course_name' => 'Test Course',
            'course_slug' => 'test-course',
            'code' => 'test',
            'course_description' => '',
            'post_notes' => '',
            'course_image' => ''
        ]);
        
        QuizPassingRate::create([
            'course_id' => 1,
            'attempt' => 1,
            'score' => 75
        ]);
    }
}

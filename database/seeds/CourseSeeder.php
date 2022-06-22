<?php

use Illuminate\Database\Seeder;
use App\Course;
use App\Quiz;
use App\QuizChoice;
use App\QuizPassingRate;
use App\Module;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $course = Course::create([
            'course_name' => 'Test Course',
            'course_slug' => 'test-course',
            'code' => 'test',
            'course_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Libero enim sed faucibus turpis in eu mi bibendum neque. Nisi lacus sed viverra tellus in hac habitasse platea. In fermentum et sollicitudin ac orci phasellus egestas. In hac habitasse platea dictumst. Lorem donec massa sapien faucibus et molestie ac feugiat',
            'content' => '<p><b>Hello!&nbsp;</b></p><p>Neque egestas congue quisque egestas diam in arcu cursus euismod. Natoque penatibus et magnis dis parturient montes nascetur. Cras tincidunt lobortis feugiat vivamus at. Gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Proin fermentum leo vel orci porta. Neque sodales ut etiam sit amet nisl purus in. Ullamcorper velit sed ullamcorper morbi tincidunt ornare. Augue lacus viverra vitae congue</p>',
            'post_notes' => '<p><b>Congratulations!&nbsp;</b></p><p>Neque egestas congue quisque egestas diam in arcu cursus euismod. Natoque penatibus et magnis dis parturient montes nascetur. Cras tincidunt lobortis feugiat vivamus at. Gravida dictum fusce ut placerat orci nulla pellentesque dignissim. Ipsum faucibus vitae aliquet nec ullamcorper sit amet risus. Proin fermentum leo vel orci porta. Neque sodales ut etiam sit amet nisl purus in. Ullamcorper velit sed ullamcorper morbi tincidunt ornare. Augue lacus viverra vitae congue</p>',
            'course_image' => 'asdasd.jpg',
            'course_cert' => 'template\cert-test-c.pdf'
        ]);
        
        $modules = [
            ['module_name' => 'Textual Module','module_slug' => 'module-text', 'module_type' => 'text','video_url' => null, 'module_content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sollicitudin ac orci phasellus egestas tellus rutrum. Nunc lobortis mattis aliquam faucibus purus in massa tempor nec. At urna condimentum mattis pellentesque id nibh tortor id aliquet. Consectetur a erat nam at lectus urna duis convallis. Volutpat est velit egestas dui id ornare arcu. Id nibh tortor id aliquet lectus proin. Quam id leo in vitae turpis massa.</p><hr><ul>
            <li>Eget lorem dolor sed viverra ipsum</li>
            <li>Enim tortor at auctor urna. Libero enim sed faucibus turpis in eu</li>
            <li>Laoreet non curabitur gravida arcu ac tortor dignissim</li>
            <li>Pellentesque adipiscing commodo elit at imperdiet</li>
            <li>Morbi leo urna molestie at elementum eu facilisis sed odio</li>
            </ul>', 'module_image' => null],
            ['module_name' => 'Video Module','module_slug' => 'module-video', 'module_type' => 'video','video_url' => 'https://www.youtube.com/embed/sL3kLxsy-Lg', 'module_content' => null, 'module_image' => null],
            ['module_name' => 'Exam Module','module_slug' => 'module-exam', 'module_type' => 'post','video_url' => null, 'module_content' => null, 'module_image' => null],
        ];

        foreach($modules as $k => $module) {
            Module::create([
                'course_id' => $course->id,
                'module_name' => $module['module_name'],
                'module_slug' => $module['module_slug'],
                'module_type' => $module['module_type'],
                'video_url' => $module['video_url'],
                'module_content' => $module['module_content'],
                'module_image' => null,
                'module_order' => $k+1
            ]);
        }

        $quizzes = [
            ['question' => 'A. Arcu bibendum at varius vel'],
            ['question' => 'B. Turpis egestas sed tempus urna'],
            ['question' => 'C. Vivamus at augue eget arcu dictum varius duis'],
            ['question' => 'D. Euismod quis viverra nibh cras pulvinar mattis nunc sed blandit'],
            ['question' => 'E. Nec feugiat in fermentum posuere urna nec tincidunt praesent'],
            ['question' => 'F. Ut faucibus pulvinar elementum integer enim neque'],
            ['question' => 'G. Quam id leo in vitae turpis massa'],
            ['question' => 'H. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua'],
            ['question' => 'I. Quam id leo in vitae turpis massa. Faucibus scelerisque eleifend donec pretium vulputate sapien nec sagittis aliquam'],
            ['question' => 'J. Sed enim ut sem viverra'],
        ];

        $quizChoices = [
            ['choice' => 'Choice A', 'is_correct' => 0],
            ['choice' => 'Choice B*', 'is_correct' => 1],
            ['choice' => 'Choice C', 'is_correct' => 0],
            ['choice' => 'Choice D', 'is_correct' => 0],
        ];

        foreach($quizzes as $quiz) {
            $question = Quiz::create([
                'course_id' => $course->id,
                'question' => $quiz['question'],
                'quiz_type' => 'post',
                'score_value' => 1
            ]);

            foreach($quizChoices as $choice) {
                QuizChoice::create([
                    'quiz_id' => $question->id,
                    'choice' => $choice['choice'],
                    'is_correct' => $choice['is_correct']
                ]);
            }
        }

        QuizPassingRate::create([
            'course_id' => $course->id,
            'attempt' => 1,
            'score' => 50,
            'exam_type' => 'post'
        ]);
    }
}

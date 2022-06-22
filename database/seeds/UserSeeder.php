<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;
use App\Position;
use App\Department;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['position_title' => 'Student'],
            ['position_title' => 'Teacher'],
            ['position_title' => 'Professional'],
            ['position_title' => 'Others'],
        ];

        foreach($positions as $position) {
            Position::create([
                'position_title' => $position->position_title
            ]);
        }

        $departments = [
            ['department' => 'Academe'],
            ['department' => 'Tech Industry'],
            ['department' => 'Manufacturing'],
            ['department' => 'Health Industry'],
        ];

        foreach($departments as $department) {
            Department::create([
                'department' => $position->department
            ]);
        }

        Employee::create([
            'emp_id' => '123456',
            'firstname' => 'Learner',
            'lastname' => 'A',
            'birthdate' => '2000-01-01',
            'email' => 'binarybee.solutions@gmail.com',
            'position_id' => 1,
            'department_id' => 2
        ]);

        User::create([
            'emp_id' => '12345',
            'password' => bcrypt('password'),
            'role' => 1,
            'email' => 'binarybee.solutions@gmail.com'
        ]);
    }
}

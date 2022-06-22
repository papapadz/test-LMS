<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'emp_id', 'password', 'email', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

     public function employee() {
         return $this->belongsTo(Employee::class,'emp_id','emp_id');
     }

    public function courseReviewer() {
        return $this->hasMany(Reviewer::class,'user_id','id');
    }

    public function employeeCourses() {
        return $this->hasMany(EmployeeCourse::class,'emp_id','emp_id')->orderBy('created_at','desc')->with(['course']);
    }

    public function employeeQuizzes() {
        return $this->hasMany(EmployeeQuiz::class,'emp_id','emp_id')->with('certificate');
    }
}

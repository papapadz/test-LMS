<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
    protected $primaryKey  = 'emp_id';
    protected $casts = ['emp_id'=>'text']; 
    protected $fillable = [
        'emp_id', 
        'firstname', 
        'middlename', 
        'lastname', 
        'birthdate', 
        'email', 
        'position_id',
        'department_id'
    ];

    public function user() {
        return $this->hasOne(User::class,'emp_id','emp_id');
    }

    public function position() {
        return $this->hasOne(Position::class,'id','position_id');
    }

    public function department() {
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function course() {
        return $this->hasMany(EmployeeCourse::class,'emp_id','emp_id');
    }
}

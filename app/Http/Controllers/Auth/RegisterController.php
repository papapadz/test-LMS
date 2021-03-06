<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Employee;
use App\Position;
use App\Department;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register')->with([
            'positions'=>Position::get(),
            'departments'=>Department::orderBy('department')->get()
        ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'emp_id' => ['required', 'string', 'min:6','unique:users'],
            'firstname' => ['required'],
            'lastname' => ['required'],
            'birthdate' => ['required'],
            'email' => ['required','unique:users'],
            'position' => ['required'],
            'department' => ['required'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);
            
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        Employee::create([
            'emp_id' => $data['emp_id'],
            'firstname' => $data['firstname'],
            'middlename' => $data['middlename'],
            'lastname' => $data['lastname'],
            'birthdate' => Carbon::parse($data['birthdate'])->toDateString(),
            'email' => $data['email'],
            'position_id' => $data['position'],
            'department_id' => $data['department'],
        ]);

        return User::create([
            'emp_id' => $data['emp_id'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'role' => 0
        ]);
    }
}

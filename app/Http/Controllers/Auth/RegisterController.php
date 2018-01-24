<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Faker\Provider\Uuid;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/schedules';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users',
            'password' => 'sometimes|string|min:6|confirmed',
            'token' => 'required|sms'
        ]);
    }

    public function username()
    {
        return 'phone';
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['phone'],
            $this->username() => $data[$this->username()],
            'password' => bcrypt(array_key_exists('password',$data)?$data['password']:$data['phone'].'secret'),
            'api_token' => Uuid::uuid()
        ]);
    }

    protected function registered(Request $request, $user)
    {
        //TODO  if (!session()->has('openid'))
        $user->attachRole(Role::where('name', 'operator')->first());
        if ($request->ajax())
            return ['success' => true];
    }
}

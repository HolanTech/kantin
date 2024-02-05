<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
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
    public function showRegistrationForm()
    {
        // Mengambil semua data sekolah
        return view('auth.register');
    }
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $sekolah = Sekolah::all();
        $this->middleware('guest');
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
            'name' => ['required', 'string', 'max:255'],
            'rfid' => ['required', 'string', 'max:255', 'unique:users'], // tambahkan ini
            'no_hp' => ['required', 'string', 'max:255'], // tambahkan ini
            'role' => ['required', 'string', 'max:255'], // tambahkan ini
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'rfid' => $data['rfid'],
            'no_hp' => $data['no_hp'],
            'role' => $data['role'],
            'password' => Hash::make('123456'),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // protected $redirectTo = '/home';
    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect('admin');
        } elseif ($user->role === 'pengelola') {
            return redirect('home');
        } elseif ($user->role === 'pengguna') {
            return redirect('order');
        }
        // Default redirect

    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'rfid';
        return $this->guard()->attempt(
            [$field => $login, 'password' => $request->input('password')],
            $request->filled('remember')
        );
    }
    public function logout(Request $request)
    {
        // Tambahkan logika yang diinginkan sebelum proses logout, misalnya logging.

        // Lakukan logout
        $this->guard()->logout();

        // Invalidate session
        $request->session()->invalidate();

        // Regenerate token
        $request->session()->regenerateToken();

        // Redirect ke halaman yang diinginkan setelah logout
        return redirect('/');
    }
}

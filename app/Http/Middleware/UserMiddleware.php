<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role == 'pengguna') {
            return $next($request);
        }
        Auth::logout(); // Memaksa logout

        // Menambahkan pesan peringatan setelah redirect.
        // Pesan ini bisa ditampilkan di halaman login.
        Session::flash('warning', 'Akses ditolak. Silakan login kembali sesuai dengan role Anda.');
        // Redirect jika bukan user biasa
        return redirect('/');
    }
}

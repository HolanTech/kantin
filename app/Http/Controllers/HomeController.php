<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Drink;
use App\Models\Order;
use App\Models\Snack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Dalam controller
    public function index()
    {
        $id = Auth::id();
        // Menggunakan whereDate untuk membandingkan kolom 'tanggal' dengan tanggal hari ini
        $orderCount = Order::where('kantin_id', $id)
            ->whereDate('tanggal', now()->toDateString())
            ->count();
        $foods = Food::where('kantin_id', $id)->get(); // asumsikan Anda memiliki model Food
        $drinks = Drink::where('kantin_id', $id)->get(); // asumsikan Anda memiliki model Drink
        $snacks = Snack::where('kantin_id', $id)->get(); // asumsikan Anda memiliki model Snack

        return view('home', compact('foods', 'drinks', 'snacks', 'orderCount'));
    }

    public function homeuser()
    {
        return view('user.home');
    }
}

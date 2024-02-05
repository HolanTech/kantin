<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\User;
use App\Models\Drink;
use App\Models\Order;
use App\Models\Saldo;
use App\Models\Snack;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }
    public function create()
    {
        $id = Auth::id();
        $foods = Food::where('kantin_id', $id)->where('status', 'ready')->orderByDesc('like')->get();
        $drinks = Drink::where('kantin_id', $id)->where('status', 'ready')->orderByDesc('like')->get();
        $snacks = Snack::where('kantin_id', $id)->where('status', 'ready')->orderByDesc('like')->get();
        $saldo = Saldo::all();
        // dd($id, $foods, $drinks, $snacks);
        return view('order.create', compact('foods', 'drinks', 'snacks', 'saldo'));
    }
    public function storeOrder(Request $request)
    {
        // Validasi data pesanan
        $request->validate([
            // Sesuaikan dengan aturan validasi yang dibutuhkan
        ]);

        // Ambil data pesanan dari request
        $orderData = $request->all();

        // Simpan pesanan ke database
        $order = Order::create($orderData);

        // Proses pembayaran atau tindakan lain sesuai kebutuhan

        // Berikan respons sesuai kebutuhan
        return response()->json(['success' => true, 'order_id' => $order->id]);
    }
    public function checkRFID(Request $request)
    {
        $rfidData = $request->input('rfidData');
        $user = Saldo::where('rfid', $rfidData)->first();

        if ($user) {
            return Response::json(['registered' => true, 'saldo' => $user->saldo]);
        } else {
            return Response::json(['registered' => false]);
        }
    }
    public function updateSaldo(Request $request)
    {
        // Validasi data pembaruan saldo
        $request->validate([
            'rfidData' => 'required',
            'newSaldo' => 'required|numeric',
        ]);

        // Ambil data dari request
        $rfidData = $request->input('rfidData');
        $newSaldo = $request->input('newSaldo');

        // Temukan pengguna berdasarkan RFID
        $user = User::where('rfid', $rfidData)->first();

        // Perbarui saldo pengguna
        if ($user) {
            $user->saldo = $newSaldo;
            $user->save();
        }

        // Berikan respons sesuai kebutuhan
        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
    public function user()
    {
        $users = User::where('role', 'pengguna')->get();
        return view('admin.user.index', compact('users'));
    }
    public function topup()
    {
        $users = User::where('role', 'pengguna')->get();

        return view('admin.user.topup', compact('users'));
    }



    public function topupstore(Request $request)
    {
        // Validasi request
        $request->validate([
            'rfidInputTopUp' => 'required',
            'nominalInput' => 'required|numeric',
            'paymentMethod' => 'required|in:cash,midtrans',
        ]);

        // Cari saldo berdasarkan RFID
        $saldo = Saldo::where('rfid', $request->rfidInputTopUp)->first();

        if ($saldo) {
            // Jika saldo ada, tambahkan saldo baru
            $saldo->saldo += $request->nominalInput;
        } else {
            // Jika saldo tidak ada, buat saldo baru
            $saldo = new Saldo();
            $saldo->rfid = $request->rfidInputTopUp;
            $saldo->saldo = $request->nominalInput;
        }

        // Simpan data ke database
        $saldo->save();

        // Perbarui saldo jika metode pembayaran adalah 'cash'
        if ($request->paymentMethod == 'cash') {
            // Logika perbarui saldo disini
            // Misalnya: $saldo->nominal += $request->nominalInput;
        }

        // Redirect atau berikan respon sesuai kebutuhan
        return redirect()->back()->with('success', 'Top-Up berhasil dilakukan. Saldo Anda sekarang: ' . $saldo->saldo);
    }

    public function checkSaldo(Request $request)
    {
        // Validasi request
        $request->validate([
            'rfidInputCheck' => 'required',
        ]);

        // Membaca data saldo dari database
        $saldo = Saldo::where('rfid', $request->rfidInputCheck)->first();

        if ($saldo) {
            // Jika saldo ada, tampilkan saldo
            return response()->json(['saldo' => $saldo->saldo]);
        } else {
            // Jika saldo tidak ada, berikan pesan tidak ditemukan
            return response()->json(['error' => 'RFID tidak ditemukan']);
        }
    }


    public function canteen()
    {
        $canteens = User::where('role', 'pengelola')->get();
        return view('admin.canteen.index', compact('canteens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

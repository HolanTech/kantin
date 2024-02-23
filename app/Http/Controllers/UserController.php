<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rfid' => 'required|string|max:255|unique:users,rfid', // Memastikan rfid unik
            'no_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:pengguna,pengelola',
        ]);

        DB::beginTransaction();

        try {
            $user = new User;
            $user->name = $request->name;
            $user->rfid = $request->rfid;
            $user->no_hp = $request->no_hp;
            $user->role = $request->role;

            // Enkripsi password hanya jika field diisi
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Menambahkan data ke tabel saldo
            $saldo = new Saldo;
            $saldo->rfid = $request->rfid; // Asumsi tabel saldo memiliki kolom rfid
            $saldo->saldo = 0; // Set saldo awal ke 0
            $saldo->save();

            DB::commit();

            return redirect()->back()->with('success', 'User and initial balance added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Gagal menambahkan user dan saldo, kembalikan error
            return redirect()->back()->with('error', 'Error adding user: ' . $e->getMessage());
        }
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
        $user = User::find($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rfid' => 'required|string|max:255|unique:users,rfid,' . $id, // pastikan rfid unik kecuali untuk user yang sedang di-update
            'no_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:pengguna,pengelola',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->rfid = $request->rfid;
        $user->no_hp = $request->no_hp;
        $user->role = $request->role;

        // Enkripsi password hanya jika field diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}

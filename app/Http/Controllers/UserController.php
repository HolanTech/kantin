<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            'username' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:pengguna,pengelola',
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->no_hp = $request->no_hp;
        $user->role = $request->role;

        // Jika password adalah teks biasa, enkripsi dengan hash
        if ($request->filled('password') && !Hash::needsRehash($request->password)) {
            $user->password = Hash::make($request->password);
        } elseif ($request->filled('password')) {
            // Jika password adalah hash, langsung simpan tanpa re-encryption
            $user->password = $request->password;
        }

        $user->save();

        return redirect()->route('admin.user')->with('success', 'User updated successfully.');
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

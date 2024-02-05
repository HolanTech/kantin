<?php

namespace App\Http\Controllers;

use App\Models\Snack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SnackController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $snacks = Snack::where('kantin_id', $id)->get();

        return view('snack.index', compact('snacks'));
    }

    public function updateStatus(Request $request)
    {
        $snack = Snack::findOrFail($request->id);

        // Ubah status
        $snack->status = ($snack->status == 'ready') ? 'not ready' : 'ready';
        $snack->save();

        // Beri respons dengan status terbaru
        return response()->json(['status' => $snack->status]);
    }

    public function create()
    {
        return view('snack.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'like' => 'nullable',
            'image' => 'required|image',
            'status' => 'required',
        ]);

        $id = Auth::id();
        $imagePath = $request->file('image')->store('public/snack_images');

        Snack::create([
            'kantin_id' => $id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'like' => $request->like,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('snack.index')->with('success', 'snack added successfully');
    }
    // Update Snack
    public function edit($id)
    {
        $snack = Snack::find($id);
        return view('snack.edit', compact('snack'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'like' => 'nullable',
            'image' => 'nullable|image',
            'status' => 'required',
        ]);

        $snack = Snack::find($id);
        $snack->name = $request->name;
        $snack->price = $request->price;
        $snack->description = $request->description;
        $snack->like = $request->like;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/snack_images');
            $snack->image = $imagePath;
        }
        $snack->status = $request->status;
        $snack->save();

        return redirect()->route('snack.index')->with('success', 'snack updated successfully');
    }

    // Delete Snack
    public function destroy($id)
    {
        $snack = Snack::find($id);
        $snack->delete();
        return redirect()->route('snack.index')->with('success', 'snack deleted successfully');
    }
}

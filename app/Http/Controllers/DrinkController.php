<?php

namespace App\Http\Controllers;


use App\Models\Drink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DrinkController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $drinks = Drink::where('kantin_id', $id)->get();
        return view('drink.index', compact('drinks'));
    }

    public function updateStatus(Request $request)
    {
        $drink = Drink::findOrFail($request->id);

        // Ubah status
        $drink->status = ($drink->status == 'ready') ? 'not ready' : 'ready';
        $drink->save();

        // Beri respons dengan status terbaru
        return response()->json(['status' => $drink->status]);
    }

    public function create()
    {
        return view('drink.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'likes' => 'nullable',
            'image' => 'required|image',
            'status' => 'required',
        ]);

        $id = Auth::id();
        $imagePath = $request->file('image')->store('public/drink_images');

        Drink::create([
            'kantin_id' => $id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'likes' => $request->like,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('drink.index')->with('success', 'drink added successfully');
    }
    // Update Drink
    public function edit($id)
    {
        $drink = Drink::find($id);
        return view('drink.edit', compact('drink'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'likes' => 'nullable',
            'image' => 'nullable|image',
            'status' => 'required',
        ]);

        $drink = Drink::find($id);
        $drink->name = $request->name;
        $drink->price = $request->price;
        $drink->description = $request->description;
        $drink->like = $request->like;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/drink_images');
            $drink->image = $imagePath;
        }
        $drink->status = $request->status;
        $drink->save();

        return redirect()->route('drink.index')->with('success', 'drink updated successfully');
    }

    // Delete Drink
    public function destroy($id)
    {
        $drink = Drink::find($id);
        $drink->delete();
        return redirect()->route('drink.index')->with('success', 'drink deleted successfully');
    }
}

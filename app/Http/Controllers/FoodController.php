<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $foods = Food::where('kantin_id', $id)->get();
        return view('food.index', compact('foods'));
    }
    public function updateStatus(Request $request, $id) // Tambahkan parameter $id
    {
        $food = Food::findOrFail($id); // Gunakan $id yang di-pass sebagai parameter

        // Ubah status
        $food->status = ($food->status == 'ready') ? 'not ready' : 'ready';
        $food->save();

        // Beri respons dengan status terbaru
        return response()->json(['status' => $food->status]);
    }



    public function create()
    {
        return view('food.create');
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
        $imagePath = $request->file('image')->store('public/food_images');

        Food::create([
            'kantin_id' => $id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'likes' => $request->like,
            'image' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('food.index')->with('success', 'Food added successfully');
    }
    // Update food
    public function edit($id)
    {
        $food = Food::find($id);
        return view('food.edit', compact('food'));
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

        $food = Food::find($id);
        $food->name = $request->name;
        $food->price = $request->price;
        $food->description = $request->description;
        $food->likes = $request->like;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/food_images');
            $food->image = $imagePath;
        }
        $food->status = $request->status;
        $food->save();

        return redirect()->route('food.index')->with('success', 'Food updated successfully');
    }

    // Delete food
    public function destroy($id)
    {
        $food = Food::find($id);
        $food->delete();
        return redirect()->route('food.index')->with('success', 'Food deleted successfully');
    }
}

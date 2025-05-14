<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Support;

class AdminGameController extends Controller
{
    public function index()
    {
        $games    = Game::orderBy('created_at', 'desc')->get();
        $supports = Support::orderBy('created_at', 'desc')->get();
        return view('admin_dashboard', compact('games', 'supports'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'category'        => 'required|string',
            'custom_category' => 'nullable|string',
            'image'           => 'required|url',
            'details'         => 'required|string',
            'price'           => 'required|numeric|min:0',
        ]);

        Game::create([
            'name'     => $data['name'],
            'category' => $data['custom_category'] ?: $data['category'],
            'image'    => $data['image'],
            'details'  => $data['details'],
            'price'    => $data['price'],
        ]);

        return back()->with('success', 'Game added successfully.');
    }

    public function destroy($id)
    {
        Game::findOrFail($id)->delete();
        return back()->with('success', 'Game deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class AdminGameController extends Controller
{
    // Show form and game list on admin dashboard
    public function create()
    {
        // Predefined categories
        $categories = ['Featured Games', 'More to Discover', 'RPG', 'FPS'];
        // Retrieve all games (ordered by creation date, newest first)
        $games = Game::orderBy('created_at', 'desc')->get();
        $supports = \App\Models\Support::all();
        return view('admin_dashboard', compact('categories', 'games','supports'));
    }

    // Store the new game from admin dashboard form
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'image'    => 'required|url',
            'name'     => 'required|string|max:255',
            'details'  => 'required|string',
            'price'    => 'required|numeric|min:0',
        ]);

        Game::create($request->all());

        return redirect()->back()->with('success', 'Game added successfully.');
    }

    // Delete a game by its ID
    public function destroy($id)
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return redirect()->back()->with('success', 'Game deleted successfully.');
    }
}

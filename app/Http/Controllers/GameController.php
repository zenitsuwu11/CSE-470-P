<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        // Get all games ordered by category and name
        $games = Game::orderBy('category')->orderBy('name')->get();
        // Group games by category
        $groupedGames = $games->groupBy('category');
        return view('dashboard', compact('groupedGames'));
    }

    // Example search method (if used)
    public function search(Request $request)
    {
        // Your search logic...
    }
}

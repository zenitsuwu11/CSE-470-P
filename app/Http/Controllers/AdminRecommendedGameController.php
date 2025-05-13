<?php
namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class AdminRecommendedGameController extends Controller
{
    public function index()
    {
        $games = Game::all(); // Fetch all games
        return view('admin_recommended', compact('games'));
    }

    public function toggle(Game $game)
    {
        $game->is_recommended = !$game->is_recommended;  // Toggle recommendation status
        $game->save();

        return redirect()->route('admin.recommended')->with('success', 'Game recommendation status updated.');
    }
}

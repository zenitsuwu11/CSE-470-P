<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Comment;
use App\Models\Purchase;
use App\Models\GameNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    // Display recommended and grouped games
    public function index()
    {
        // Fetch all recommended games without pagination
        $recommendedGames = Game::where('is_recommended', true)->get();  // Removed pagination
        $games = Game::orderBy('category')->orderBy('name')->get(); // Get all games, ordered by category and name
        $groupedGames = $games->groupBy('category'); // Group games by category
        $allGames = Game::orderBy('name')->get(); // Fetch all games without grouping
    
        // Return the view with the recommended games, grouped games, and all games
        return view('dashboard', compact('recommendedGames', 'groupedGames', 'allGames'));
    }
    

    // Search method to return matching games as JSON
    public function search(Request $request)
    {
        $query = $request->input('q');
        $games = Game::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($games);
    }

    // Show the invoice for a selected game
    public function showInvoice($gameId)
    {
        $game = Game::findOrFail($gameId);
        return view('invoice', compact('game'));
    }

    // Handle the purchase and deduct balance from the user
    public function confirmPurchase(Request $request, $gameId)
    {
        $game = Game::findOrFail($gameId);
        $user = Auth::user();

        // Prevent duplicate purchase
        $alreadyPurchased = Purchase::where('user_id', $user->id)
                                    ->where('game_id', $game->id)
                                    ->exists();

        if ($alreadyPurchased) {
            return redirect()->route('dashboard')->with('error', 'You have already purchased this game.');
        }

        // Check balance and proceed with purchase
        if ($user->balance->amount >= $game->price) {
            $user->balance->amount -= $game->price;
            $user->balance->save();

            Purchase::create([
                'user_id' => $user->id,
                'game_id' => $game->id,
                'amount_spent' => $game->price,
            ]);

            return redirect()->route('dashboard')->with('success', 'Purchase successful!');
        }

        return redirect()->route('dashboard')->with('error', 'Insufficient balance to purchase this game.');
    }

    // Show user's purchased games
    public function library()
    {
        $purchasedGames = Purchase::with('game')
            ->where('user_id', Auth::id())
            ->get();

        return view('library', compact('purchasedGames'));
    }

    // Delete a game from the user's library
    public function deleteFromLibrary($purchaseId)
    {
        $purchase = Purchase::findOrFail($purchaseId);

        if ($purchase->user_id !== Auth::id()) {
            return redirect()->route('library')->with('error', 'Unauthorized action.');
        }

        $purchase->delete();

        return redirect()->route('library')->with('success', 'Game removed from your library.');
    }

    // Increment the like counter for a game
    public function likeGame($gameId)
    {
        $game = Game::findOrFail($gameId);
        $game->likes += 1;
        $game->save();

        return response()->json(['likes' => $game->likes], 200);
    }

    // Add a new comment to a game
    public function addComment(Request $request, $gameId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $game = Game::findOrFail($gameId);

        Comment::create([
            'game_id' => $game->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    // Display reviews (comments) for a specific game
    public function showReviews($gameId)
    {
        $game = Game::with(['comments.user'])->findOrFail($gameId);
        return view('games.reviews', compact('game'));
    }

    // Show patch updates (filtered by type)
    public function patchUpdates()
    {
        $patchUpdates = GameNews::where('type', 'patch')->orderBy('release_date', 'desc')->paginate(10);
        return view('patch_updates', compact('patchUpdates'));
    }
}

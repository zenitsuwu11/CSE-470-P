<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    // Display all games grouped by category
    public function index()
    {
        $games = Game::orderBy('category')->orderBy('name')->get();
        $groupedGames = $games->groupBy('category');
        return view('dashboard', compact('groupedGames'));
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

        // ✅ Prevent duplicate purchase
        $alreadyPurchased = Purchase::where('user_id', $user->id)
                                    ->where('game_id', $game->id)
                                    ->exists();

        if ($alreadyPurchased) {
            return redirect()->route('dashboard')->with('error', 'You have already purchased this game.');
        }

        // ✅ Check balance and proceed with purchase
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
}

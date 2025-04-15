<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserBalance;
use App\Models\BalanceTransaction;
use App\Models\Game; // Make sure you have a Game model

class PurchaseController extends Controller
{
    public function buy($gameId)
    {
        $user = Auth::user();
        $game = Game::findOrFail($gameId);
        $price = $game->price;

        // Get or create user's balance record
        $balanceRecord = UserBalance::firstOrCreate(
            ['user_id' => $user->id],
            ['balance' => 0]
        );

        // Check if the user has enough balance.
        if ($balanceRecord->balance < $price) {
            return redirect()->back()->with('error', 'Not enough balance, please recharge.');
        }

        // Deduct game price from the user's balance.
        $balanceRecord->balance -= $price;
        $balanceRecord->save();

        // Record the transaction.
        BalanceTransaction::create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'amount'  => $price,
            'type'    => 'deduction'
        ]);

        // Prepare invoice data.
        $invoiceData = [
            'game'              => $game,
            'price'             => $price,
            'remaining_balance' => $balanceRecord->balance,
            'date'              => now()
        ];

        // Show an invoice view (create the invoice view file below).
        return view('invoice', $invoiceData);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceRequest;
use App\Models\Purchase;
use App\Models\UserBalance; // Import UserBalance model
use App\Models\BalanceTransaction; // Import BalanceTransaction model

class BalanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get purchases and total amount spent
        $purchases = $user->purchases()->with('game')->get();
        $totalSpent = $purchases->sum('amount');

        // Get remaining balance (from UserBalance model)
        $balanceRecord = UserBalance::where('user_id', $user->id)->first(); // Corrected to UserBalance model

        // Get the balance transactions (from BalanceTransaction model)
        $transactions = $user->userBalanceTransactions()->get(); // Correct method for fetching transactions

        return view('balance', compact(
            'purchases',
            'totalSpent',
            'balanceRecord',
            'transactions'
        ));
    }

    public function requestBalance(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        BalanceRequest::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'pending',
        ]);
        $requests = BalanceRequest::with('user')->orderBy('created_at', 'desc')->get();

        return redirect()->back()->with('success', 'Balance request submitted successfully.');
    }
    
}

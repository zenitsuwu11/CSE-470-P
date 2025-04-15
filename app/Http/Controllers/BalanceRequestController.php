<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceRequest;
use App\Models\UserBalance;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\DB;

class BalanceRequestController extends Controller
{
    // Admin view of all balance requests.
    public function index()
    {
        // Eagerly load the user relationship to fetch the user's data, including the name.
        $requests = BalanceRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('balance_requests', compact('requests'));
    }

    // Approve a balance request.
    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $balanceRequest = BalanceRequest::findOrFail($id);

            if ($balanceRequest->status === 'approved') {
                return redirect()->back()->with('info', 'This request is already approved.');
            }

            $balanceRequest->status = 'approved';
            $balanceRequest->save();

            // Update or create user balance
            $userBalance = UserBalance::firstOrCreate(
                ['user_id' => $balanceRequest->user_id],
                ['amount' => 0]
            );

            $userBalance->amount += $balanceRequest->amount;
            $userBalance->save();

            // Log the transaction
            BalanceTransaction::create([
                'user_id' => $balanceRequest->user_id,
                'amount'  => $balanceRequest->amount,
                'game_id' => null,
                'type'    => 'addition',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Balance request approved.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Disapprove a balance request.
    public function disapprove($id)
    {
        $balanceRequest = BalanceRequest::findOrFail($id);
        $balanceRequest->status = 'disapproved';
        $balanceRequest->save();

        return redirect()->back()->with('success', 'Balance request disapproved.');
    }
}

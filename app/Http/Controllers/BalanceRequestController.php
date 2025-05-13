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
        $requests = BalanceRequest::with('user')
                   ->orderBy('created_at', 'desc')
                   ->get();

        return view('balance_requests', compact('requests'));
    }

    // Approve a balance request.
    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $br = BalanceRequest::findOrFail($id);

            if ($br->status === 'approved') {
                return redirect()->back()->with('info', 'This request is already approved.');
            }

            $br->status = 'approved';
            $br->save();

            $ub = UserBalance::firstOrCreate(
                ['user_id' => $br->user_id],
                ['amount'  => 0]
            );
            $ub->amount += $br->amount;
            $ub->save();

            BalanceTransaction::create([
                'user_id' => $br->user_id,
                'amount'  => $br->amount,
                'game_id' => null,
                'type'    => 'addition',
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Balance request approved.');
        }
        catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Disapprove a balance request.
    public function disapprove($id)
    {
        $br = BalanceRequest::findOrFail($id);

        // ← This must be a quoted string
        $br->status = 'disapproved';
        $br->save();

        return redirect()->back()->with('success', 'Balance request disapproved.');
    }
}

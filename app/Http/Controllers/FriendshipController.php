<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function sendRequest($userId)
    {
        Friendship::create([
            'requester_id' => Auth::id(),
            'requested_id' => $userId,
            'status'       => 'pending',
        ]);
        return response()->json(['status' => 'sent']);
    }

    public function cancelRequest($userId)
    {
        Friendship::where(function($q) use($userId){
            $q->where('requester_id', Auth::id())
              ->where('requested_id', $userId);
        })->orWhere(function($q) use($userId){
            $q->where('requester_id', $userId)
              ->where('requested_id', Auth::id());
        })->delete();

        return response()->json(['status' => 'cancelled']);
    }

    public function acceptRequest($userId)
    {
        $f = Friendship::where('requester_id', $userId)
                       ->where('requested_id', Auth::id())
                       ->first();
        $f->update(['status' => 'accepted']);
        return response()->json(['status' => 'accepted']);
    }

    public function declineRequest($userId)
    {
        Friendship::where('requester_id', $userId)
                  ->where('requested_id', Auth::id())
                  ->delete();

        return response()->json(['status' => 'declined']);
    }
}

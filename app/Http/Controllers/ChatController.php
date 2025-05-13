<?php
namespace App\Http\Controllers;

use App\Models\ChatMessage;    // ← now matches the model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function fetch($friendId)
    {
        $me = Auth::id();
        $msgs = ChatMessage::where(function($q) use($me, $friendId){
                    $q->where('from_user_id', $me)
                      ->where('to_user_id',   $friendId);
                })
                ->orWhere(function($q) use($me, $friendId){
                    $q->where('from_user_id', $friendId)
                      ->where('to_user_id',   $me);
                })
                ->orderBy('created_at')
                ->get();

        return response()->json($msgs);
    }

    public function send(Request $req, $friendId)
    {
        // now this will actually write to chat_messages
        $msg = ChatMessage::create([
            'from_user_id' => Auth::id(),
            'to_user_id'   => $friendId,
            'body'         => $req->body,
        ]);

        return response()->json($msg);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Support;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function create()
    {
        return view('support');
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|min:5',
        ]);

        $user = Auth::user();

        Support::create([
            'user_name'  => $user->name,   // Make sure this value is provided!
            'user_email' => $user->email,
            'message'    => $request->message,
        ]);

        return redirect()->back()->with('success', 'Your support message has been submitted!');
    }

    public function destroy($id)
    {
        $support = Support::findOrFail($id);
        $support->delete();

        return redirect()->back()->with('success', 'Support message deleted.');
    }
}

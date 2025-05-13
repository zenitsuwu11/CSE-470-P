<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    public function index()
    {
        $users = User::where('id', '<>', Auth::id())->get();
        return view('social', compact('users'));
    }
}

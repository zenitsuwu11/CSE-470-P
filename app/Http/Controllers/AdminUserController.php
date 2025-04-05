<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        // Get all users sorted alphabetically by name
        $users = User::orderBy('name', 'asc')->get();
        return view('admin_users', compact('users'));
    }
}

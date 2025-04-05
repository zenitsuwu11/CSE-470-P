<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Show the profile page
    public function show()
    {
        return view('profile');
    }

    // Update username and email (General Tab)
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        // Update the 'name' field using the username input
        $user->name  = $request->input('username');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Update password (Change Password Tab)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is wrong.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    // Update additional information (Info Tab)
    public function updateInfo(Request $request)
    {
        $request->validate([
            'bio'      => 'nullable|string',
            'birthday' => 'nullable|string',
            'country'  => 'nullable|string',
            'phone'    => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->bio      = $request->input('bio');
        $user->birthday = $request->input('birthday');
        $user->country  = $request->input('country');
        $user->phone    = $request->input('phone');
        $user->save();

        return redirect()->back()->with('success', 'Information updated successfully.');
    }

    // Delete account (Delete Account Tab)
    public function deleteAccount(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->delete();
        Auth::logout();
        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}

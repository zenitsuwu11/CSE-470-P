<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    // Show the admin profile page
    public function show()
    {
        return view('admin_profile');
    }

    // Update username and email (General Tab)
    public function updateGeneral(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255',
        ]);

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $admin->name  = $request->input('username');
        $admin->email = $request->input('email');
        $admin->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Update password (Change Password Tab)
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6|confirmed',
        ]);

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        if (!Hash::check($request->input('current_password'), $admin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is wrong.']);
        }

        $admin->password = Hash::make($request->input('new_password'));
        $admin->save();

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

        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $admin->bio      = $request->input('bio');
        $admin->birthday = $request->input('birthday');
        $admin->country  = $request->input('country');
        $admin->phone    = $request->input('phone');
        $admin->save();

        return redirect()->back()->with('success', 'Information updated successfully.');
    }

    // Delete account (Delete Account Tab)
    public function deleteAccount(Request $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $admin->delete();
        Auth::guard('admin')->logout();
        return redirect('/')->with('success', 'Your account has been deleted.');
    }
}

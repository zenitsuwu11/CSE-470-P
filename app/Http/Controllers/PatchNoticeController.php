<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatchNotice;

class PatchNoticeController extends Controller
{
    // Show the form to create a new patch notice
    public function create()
    {
        return view('admin.patch-notice.create');
    }

    // Store the new patch notice in the database
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'patch_title' => 'required|string|max:255',
            'patch_description' => 'required|string',
            'patch_notes' => 'nullable|string',
        ]);

        // Create a new PatchNotice record
        PatchNotice::create([
            'title' => $request->patch_title,
            'description' => $request->patch_description,
            'notes' => $request->patch_notes,
        ]);

        // Redirect back with a success message
        return redirect()->route('patch.index')->with('success', 'Patch notice created successfully!');
    }

    // Display patch updates
    public function patchUpdates()
    {
        // Fetch the patch updates from the database, ordered by the latest ones
        $patchUpdates = PatchNotice::orderBy('created_at', 'desc')->paginate(10);

        // Pass the patch updates to the view
        return view('patch_updates', compact('patchUpdates'));
    }
}

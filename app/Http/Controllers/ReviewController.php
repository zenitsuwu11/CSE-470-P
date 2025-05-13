<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Handle a review submission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
            'rating'  => 'required|integer|between:1,5',
        ]);

        // Log the authenticated user's ID (for debugging)
        \Log::info('Authenticated User ID: ' . Auth::id());

        // Check if user is authenticated
        if (Auth::check()) {
            // Ensure user_id is passed with the review creation
            Review::create([
                'user_id' => Auth::id(), // This will fill user_id
                'title'   => $request->input('title'),
                'comment' => $request->input('comment'),
                'rating'  => $request->input('rating'),
            ]);

            return redirect()->route('reviews.index')
                             ->with('success', 'Review submitted successfully.');
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to submit a review.');
        }
    }

    /**
     * Show all reviews.
     */
    public function index()
    {
        // Fetch all reviews with their authors
        $reviews = Review::with('user')->latest()->get();
        return view('game_reviews', compact('reviews'));
    }
}

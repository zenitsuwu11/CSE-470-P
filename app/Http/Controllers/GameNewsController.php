<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameNews;
use App\Models\Review;

class GameNewsController extends Controller
{
    public function index()
    {
        // 1) Fetch Game News (paginated)
        $newsItems = GameNews::with('game')
                             ->orderBy('release_date', 'desc')
                             ->paginate(10);

        // 2) Fetch Reviews separately (you could paginate this too)
        $reviews = Review::with('user')
                         ->orderBy('created_at', 'desc')
                         ->get();

        // 3) Return both to the view
        return view('game_news', compact('newsItems', 'reviews'));
    }
}

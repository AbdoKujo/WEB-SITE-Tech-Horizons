<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use App\Models\Article;

class HistoryController extends Controller
{
    public function index()
{
    // Fetch history items ordered by visited_at in descending order
    $history = History::with('article')
                      ->where('user_id', auth()->id()) // Only fetch history for the logged-in user
                      ->orderBy('visited_at', 'desc') // Newest first
                      ->get();
                      
    
    return view('history', compact('history'));
}
}

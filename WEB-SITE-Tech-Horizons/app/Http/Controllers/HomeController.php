<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\History;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Article;
use App\Models\Numero;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = auth()->user();
        $themes = Theme::all(); // Fetch all themes

        // Fetch latest articles from history
        $latestArticles = History::where('user_id', $user->id)
            ->where('type', 'article')
            ->orderBy('visited_at', 'desc')
            ->get()
            ->unique('item_id') // Ensure unique articles
            ->take(5) // Limit to 5 articles
            ->map(function ($history) {
                return $history->article; // Map to the article
            })
            ->filter(); // Remove null values

        // Fetch abonnés (users with type_id = 3) and exclude the current user (Editeur)
        $abonnes = User::where('type_id', 3) // Only users with type_id = 3 (Abonné)
            ->where('id', '!=', $user->id) // Exclude the current user (Editeur)
            ->get();

        // Fetch all articles
        $articles = Article::all();

        // Fetch all numeros with their articles
        $numeros = Numero::with('articles')->get();

        return view('home', compact('themes', 'latestArticles', 'abonnes', 'articles', 'numeros'));
    }
   

    

    // Delete a theme
    public function destroy(Theme $theme)
    {
        // Delete the theme
        $theme->delete();

        return redirect()->route('home')->with('success', 'Theme deleted successfully!');
    }


}

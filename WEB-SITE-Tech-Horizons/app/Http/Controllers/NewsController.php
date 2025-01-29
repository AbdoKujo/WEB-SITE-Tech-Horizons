<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Numero;
use App\Models\Article;

class NewsController extends Controller
{
    public function index()
    {
        // Récupérer les thèmes et les numéros avec leurs articles associés
        $themes = Theme::all();
        $numeros = Numero::with('articles')->get();
        $top = Article::where('is_favorise', true)->limit(5)->get();
        $last = Article::orderBy('created_at', 'desc')->limit(5)->get();

        // Passer les données à la vue
        return view('news.news ', compact('themes', 'numeros' , 'top' , 'last'));
    }
}
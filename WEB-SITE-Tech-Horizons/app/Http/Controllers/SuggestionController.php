<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Numero;
use App\Models\Article;
use App\Models\Theme;

class SuggestionController extends Controller
{
    public function index()
    {
        //$suggestions = Article::all(); // Vous pouvez ajouter des filtres ou des conditions ici
        $themes = Theme::all(); // Récupérer tous les thèmes
        // Récupérer les articles retenus et favorisés
        $articles = Article::all();//where('status', 'retenu')->where('is_favorise', 1)->get();

        // Récupérer les suggestions (ajustez cette partie selon votre logique)
        $suggestions = Article::all();//where('status', 'En cours')->get();

        $numeross = Numero::all();
        //dd($numeros);

        // Passer les articles et les suggestions à la vue
        return view('suggestions', compact('articles', 'suggestions', 'themes' , 'numeross'));
    }
}
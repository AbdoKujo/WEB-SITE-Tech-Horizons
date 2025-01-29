<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Theme;
use App\Models\Numero;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{
    public function index(Request $request)
    {
        // Récupérer les thèmes et les articles associés
        $themes = Theme::with('articles')->get();

        // Vérifier le rôle de l'utilisateur
        $user = Auth::user();
        if ($user && (
            $user->type->name === 'Abonné' ||
            $user->type->name === 'Editeur' ||
            str_contains($user->type->name, 'Responsable')
        )) {
            // Si l'utilisateur a un rôle spécifique, récupérer tous les numéros
            $publishedNumeroIds = Numero::pluck('id');
        } else {
            // Sinon, récupérer uniquement les numéros publiés
            $publishedNumeroIds = Numero::where('status', 'public')->pluck('id');
        }
        // Récupérer l'ID du numéro sélectionné
        $selectedNumeroId = $request->input('id_numero');

        // Récupérer les articles associés aux numéros publiés avec pagination
        $query = Article::whereIn('id_numero', $publishedNumeroIds);

        if ($selectedNumeroId) {
            $query->where('id_numero', $selectedNumeroId);
        }

        $Narticles = $query->paginate(6); // 10 articles par page

        // Passer les données à la vue
        return view('welcome', compact('themes', 'Narticles', 'publishedNumeroIds', 'selectedNumeroId'));
    }
}
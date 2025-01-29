<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\User;

class ThemeController extends Controller
{
    public function index()
    {
        // Récupérer tous les thèmes
        $themes = Theme::all();
       // Récupérer tous les articles ayant un id_numero
       $Narticles = Article::whereNotNull('id_numero')->get();

       $public = Article::where('status', 'publié')->get();
    
       // Retourner la vue avec les thèmes et les articles
       return view('themes', compact('themes', 'Narticles' , 'public'));
   }
   
    public function show($id)
    {
        $theme = Theme::with('articles')->findOrFail($id);

        $user = auth()->user();
        $isResponsable = isset($user) && $user->isResponsable() && $user->id === $theme->responsable_id;
        $isEditeur = isset($user) && $user->isEditeur();
        $isAbonne = isset($user) && $user->isAbonne();

        // Récupérer les articles en fonction de l'état de l'utilisateur
        if ($isAbonne) {
            $articles = $theme->articles()->whereNotNull('id_numero')->get();
        } else {
            $articles = $theme->articles()->where('status', 'publié')->get();
        }

        if($user){
        History::create([
            'user_id' => $user->id,
            'type' => 'theme',
            'item_id' => $theme->id,
            'visited_at' => now(),
        ]);

        }

        return view('themes', compact('theme', 'isResponsable', 'isEditeur' , 'isAbonne', 'articles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'responsable_id' => 'nullable|exists:users,id',
        ]);

        $theme = Theme::create([
            'name' => $request->name,
            'responsable_id' => $request->responsable_id,
        ]);

        if ($request->responsable_id) {
            User::where('id', $request->responsable_id)->update(['type_id' => 2]);
        }

        return redirect()->route('home')->with('success', 'Theme created successfully!');
    }

    public function subscribe(Theme $theme, Request $request)
{
    $user = auth()->user();

    // Prevent subscription if the user is the responsable for this theme
    if ($user->isResponsable() && $user->id === $theme->responsable_id) {
        return redirect()->back()->withErrors('You cannot subscribe to a theme you manage.');
    }

    // Toggle subscription
    if ($user->themes()->where('theme_id', $theme->id)->exists()) {
        $user->themes()->detach($theme->id);
        $message = 'Unsubscribed successfully!';
    } else {
        $user->themes()->attach($theme->id);
        $message = 'Subscribed successfully!';
    }

    return redirect()->back()->with('status', $message);
}

    public function approve(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        if (auth()->id() !== $article->theme->responsable_id) {
            abort(403, 'Unauthorized action.');
        }

        $action = $request->input('action');
        $status = $action === 'approve' ? 'publié' : 'refusé';
        $article->update(['status' => $status]);

        return redirect()->back()->with('status', "Article {$status} successfully!");
    }

    public function deleteArticle($articleId)
    {
        $article = Article::findOrFail($articleId);

        if (auth()->id() !== $article->theme->responsable_id && auth()->user()->type->name !== 'Editeur') {
            abort(403, 'Unauthorized action.');
        }

        $article->delete();
        return redirect()->back()->with('status', 'Article deleted successfully!');
    }

    public function unsubscribeUser($themeId, $userId)
    {
        $user = User::findOrFail($userId);
        $user->themes()->detach($themeId);

        return redirect()->back()->with('status', 'User unsubscribed successfully!');
    }

    public function destroy($id)
    {
        // Récupérer le thème par son ID
        $theme = Theme::findOrFail($id);
        
        // Récupérer le responsable du thème
        $responsable = $theme->responsable;

        // Changer le rôle du responsable en abonné
        if ($responsable) {
            $responsable->type_id = 3; // Supposons que type_id = 2 correspond au rôle 'Abonné'
            $responsable->save();
        }

        

        // Supprimer le thème
        $theme->delete();

        // Rediriger avec un message de succès
        return redirect()->route('home')->with('success', 'Theme deleted successfully.');
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Numero;
use App\Models\Article;

class NumeroController extends Controller
{
    public function store(Request $request)
    {
        $numero = Numero::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'privé',
        ]);

        // Mettre à jour les articles sélectionnés pour qu'ils référencent le numéro
        if ($request->has('articles')) {
            Article::whereIn('id', $request->articles)->update(['id_numero' => $numero->id]);
            Article::whereIn('id', $request->articles)->update(['status' => 'private']);
        }

        return redirect()->back()->with('success', 'Numéro créé avec succès.');
    }

    public function getArticlesByNumero($id)
    {
        $articles = Article::where('id_numero', $id)->get();

        return view('numero.articles', compact('articles'));
    }

    public function publish($id)
    {
        $numero = Numero::findOrFail($id);
        $numero->update(['status' => 'public']);
        Article::where('id_numero', $id)->update(['status' => 'publié']);

        return redirect()->back()->with('success', 'Numéro publié avec succès.');
    }

    public function unpublish($id)
    {
        $numero = Numero::findOrFail($id);
        $numero->update(['status' => 'privé']);
        Article::where('id_numero', $id)->update(['status' => 'retenu']);

        return redirect()->back()->with('success', 'Numéro annulé avec succès.');
    }

    public function edit($id)
    {
        $numero = Numero::findOrFail($id);
        $availableArticles = Article::where('status', 'retenu')->whereNull('id_numero')->get();
        return view('numeros.edit', compact('numero', 'availableArticles'));
    }

    public function update(Request $request, $id)
    {
        $numero = Numero::findOrFail($id);
        $numero->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->has('add_articles')) {
            Article::whereIn('id', $request->add_articles)->update(['id_numero' => $numero->id]);
        }

        return redirect()->route('home')->with('success', 'Numéro mis à jour avec succès.');
    }

    public function removeArticles(Request $request, $id)
    {
        Article::whereIn('id', $request->articles)->update(['id_numero' => null]);
        Article::whereIn('id', $request->articles)->update(['status' => 'retenu']);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $numero = Numero::findOrFail($id);
        Article::where('id_numero', $id)->update(['id_numero' => null, 'status' => 'retenu']);
        $numero->delete();

        return redirect()->route('home')->with('success', 'Numéro supprimé avec succès.');
    }
    public function show($id)
    {
        $numero = Numero::with('articles')->findOrFail($id);

        $user = auth()->user();
        $isResponsable = isset($user) && $user->isResponsable();
        $isEditeur = isset($user) && $user->isEditeur();
        $isAbonne = isset($user) && $user->isAbonne();

        return view('numeros.numero', compact('numero', 'isResponsable', 'isEditeur', 'isAbonne'));
    }
    
}
<?php

namespace App\Http\Controllers;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\History;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Models\Numero;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller{
    
    
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'theme_id' => 'required|integer',
            'numero_id' => 'nullable|exists:numeros,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Create the article
        $article = new Article();
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->theme_id = $request->input('theme_id');
        $article->user_id = auth()->id(); // Associate with the logged-in user

        if (auth()->user()->isEditeur()) {
            $article->status = 'retenu'; // Status for editors
            $article->is_favorise = true; // Mark as favorised
            $article->id_numero = $request->input('numero_id'); // Associate with the selected numero
        } else {
            $article->status = 'En cours'; // Initial status for other users
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $article->image_path = $path;
        }

        $article->save();
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Article créé avec succès.');
    }
    


    public function rate(Request $request, $id)
    {
        // Find the article
        $article = Article::findOrFail($id);
    
        // Validate the request
        $request->validate([
            'rating' => 'nullable|integer|between:1,5', // Rating is optional
            'comment' => 'nullable|string|max:1000', // Comment is optional
        ]);
    
        // Get the authenticated user
        $user = Auth::user();
    
        // Debug: Log the user and article
        \Log::info('Rating/comment request received:', [
            'user_id' => $user->id,
            'article_id' => $article->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);
    
        // Handle ratings
        if ($request->rating) {
            // Check if the user has already rated the article
            $rating = Rating::where('user_id', $user->id)
                            ->where('article_id', $article->id)
                            ->where('type', 'rating')
                            ->first();
    
            if ($rating) {
                // Update the existing rating
                $rating->update([
                    'rating' => $request->rating,
                ]);
    
                \Log::info('Updated rating:', $rating->toArray());
            } else {
                // Create a new rating
                Rating::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id,
                    'rating' => $request->rating,
                    'type' => 'rating',
                ]);
    
                \Log::info('Created new rating.');
            }
        }
    
        // Handle comments
        if ($request->comment) {
            // Create a new comment (allow multiple comments per user)
            $comment = Rating::create([
                'user_id' => $user->id,
                'article_id' => $article->id,
                'comment' => $request->comment,
                'type' => 'comment',
            ]);
    
            \Log::info('Created new comment:', $comment->toArray());
        }
    
        return response()->json(['message' => 'Interaction saved successfully!']);
    }
    




public function show($id)
{
    // Fetch the article with its theme and user
    $article = Article::with(['theme', 'user'])->findOrFail($id);

    // Fetch the user's rating for this article
    $userRating = null;
    if (auth()->check()) {
        $userRating = Rating::where('user_id', auth()->id())
                            ->where('article_id', $id)
                            ->where('type', 'rating')
                            ->first(); // Retrieve the full Rating model

        // Log the visit in the history table
        History::create([
            'user_id' => auth()->id(), // Logged-in user
            'type' => 'article', // Log as an article visit
            'item_id' => $article->id, // Use the article ID
            'visited_at' => now(),
        ]);
    }

    // Fetch all comments for the article
    $comments = Rating::where('article_id', $id)
                      ->where('type', 'comment')
                      ->public()
                      ->with('user') // Include user info for display
                      ->get();

    // Définir les variables pour les rôles
    $isResponsable = auth()->check() && auth()->user()->isResponsable() && $article->theme->responsable_id == auth()->id();
    $isEditeur = auth()->check() && auth()->user()->isEditeur();

    return view('articles', compact('article', 'userRating', 'comments', 'isResponsable', 'isEditeur'));
}


public function updateStatus(Request $request, Article $article)
{
    // Validate the request
    $request->validate([
        'status' => 'required|in:publié,refusé',
    ]);

    // Update the article status
    $article->status = $request->status;
    $article->save();

    return redirect()->back()->with('status', 'Article status updated successfully.');
}



public function deleteComment($commentId)
{
    $comment = Rating::findOrFail($commentId);
    $article = $comment->article;

    // Check if the user is a responsable and if the article's theme belongs to them
    if (auth()->user()->isResponsable() && $article->theme->responsable_id != auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // Delete the comment
    $comment->delete();

    return response()->json(['message' => 'Comment deleted successfully!']);
}

public function destroy(Article $article)
{
    // Check if the authenticated user is an editeur
    if (auth()->user()->isEditeur()) {
        // Store the theme ID before deleting the article
        $themeId = $article->theme_id;

        // Delete the article
        $article->delete();

        // Redirect to the theme's page
        return redirect()->route('themes.show', $themeId)->with('status', 'Article deleted successfully!');
    }

    return redirect()->back()->with('error', 'Unauthorized action.');
}
public function favorite($id)
{
    $article = Article::findOrFail($id);
    $article->is_favorise = true;
    $article->save();

    return redirect()->back()->with('success', 'Article favorisé avec succès.');
}

public function unfavorite($id)
{
    $article = Article::findOrFail($id);
    $article->is_favorise = false;
    $article->save();

    return redirect()->back()->with('success', 'Article défavorisé avec succès.');
}

public function approve($id)
{
    $article = Article::findOrFail($id);
    $article->status = 'retenu';
    $article->save();

    return redirect()->back()->with('success', 'Article approuvé avec succès.');
}

public function reject($id)
{
    $article = Article::findOrFail($id);
    $article->status = 'rejeté';
    $article->save();

    return redirect()->back()->with('success', 'Article rejeté avec succès.');
}

public function publish($id)
{
    $article = Article::findOrFail($id);
    $article->status = 'publié';
    $article->save();

    return redirect()->back()->with('success', 'Article publié avec succès.');
}
public function bulkAction(Request $request)
{
    $action = $request->input('action');
    $articleIds = $request->input('articles', []);

    if (empty($articleIds)) {
        return back()->with('error', 'Aucun article sélectionné.');
    }

    $status = '';
    switch ($action) {
        case 'approve':
            $status = 'retenu';
            break;
        case 'reject':
            $status = 'rejeté';
            break;
        case 'publish':
            $status = 'publié';
            break;
        default:
            return back()->with('error', 'Action non valide.');
    }

    // Effectuer l'action en masse
    Article::whereIn('id', $articleIds)->update(['status' => $status]);

    $count = count($articleIds);
    $message = "{$count} article" . ($count > 1 ? 's' : '') . " ont été {$status} avec succès.";

    return back()->with('success', $message);
}
}

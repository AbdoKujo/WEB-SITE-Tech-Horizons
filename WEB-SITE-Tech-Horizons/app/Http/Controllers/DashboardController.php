<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Article;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        // Check if the user is authenticated
        if (!$user) {
            return redirect()->route('login');
        }
    
        if ($user->isResponsable()) {
            // Responsable-specific data
            $managedThemes = Theme::where('responsable_id', $user->id)->get();
            $subscribedUsers = collect();
            foreach ($managedThemes as $theme) {
                $subscribedUsers = $subscribedUsers->merge($theme->users);
            }
            $suggestedArticles = Article::whereIn('theme_id', $managedThemes->pluck('id'))
                                        ->orderBy('created_at', 'desc')
                                        ->get();
    
            return view('responsable.dashboard', compact('managedThemes', 'subscribedUsers', 'suggestedArticles'));
        } elseif ($user->isEditeur()) {
            // Editeur-specific data
            $allUsers = User::where('id', '!=', $user->id)->get();
    
            // Categorize users
            $responsables = $allUsers->filter(function ($user) {
                return $user->isResponsable();
            });
    
            $abonnes = $allUsers->filter(function ($user) {
                return $user->isAbonne();
            });
    
            // Fetch suggested articles for each user
            $allUsers->each(function ($user) {
                $user->suggestedArticles = Article::where('user_id', $user->id)->get();
            });
    
            $allArticles = Article::orderBy('created_at', 'desc')->get();
    
            return view('editeur.dashboard', compact('responsables', 'abonnes', 'allArticles'));
        } else {
            // Abonné-specific data
            $subscribedThemes = $user->themes;
            $recommendedArticles = Article::whereIn('theme_id', $subscribedThemes->pluck('id'))
                                          ->orderBy('created_at', 'desc')
                                          ->get();
    
            return view('abonne.dashboard', compact('subscribedThemes', 'recommendedArticles'));
        }
    }
    
    public function getUserDetails($userId)
    {
        \Log::info('Fetching user details for user ID:', ['userId' => $userId]);
    
        try {
            $user = User::findOrFail($userId);
            \Log::info('User found:', ['user' => $user]);
    
            // Fetch suggested articles for the user using the relationship
            $suggestedArticles = $user->articles()
                ->select('id', 'title') // Remove 'image' from the select statement
                ->orderBy('created_at', 'desc')
                ->get();
               
    
            \Log::info('Suggested articles:', ['suggestedArticles' => $suggestedArticles]);
    
            // Determine the user type
            $type = 'Abonné'; // Default type
            if ($user->isResponsable()) {
                $type = 'Responsable';
            } elseif ($user->isEditeur()) {
                $type = 'Editeur';
            }
            \Log::info('User type:', ['type' => $type]);
    
            return response()->json([
                'name' => $user->name,
                'email' => $user->email,
                'type' => $type,
                'suggestedArticles' => $suggestedArticles,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in getUserDetails:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function unsubscribeUser($themeId, $userId)
    {
        $user = User::findOrFail($userId);
        $user->themes()->detach($themeId);

        return redirect()->back()->with('status', 'User unsubscribed successfully!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status', 'User deleted successfully!');
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
    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->back()->with('success', 'Article supprimé avec succès.');
    }
}
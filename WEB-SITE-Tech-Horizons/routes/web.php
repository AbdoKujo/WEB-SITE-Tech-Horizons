<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ArticleController;
use App\Models\Theme;
use App\Http\Controllers\NumeroController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\WelcomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    $themes = Theme::all(); // Fetch all themes
    return view('welcome', compact('themes')); // Pass themes to the view
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/suggestions', [App\Http\Controllers\SuggestionController::class, 'index']);
Route::get('/history', [App\Http\Controllers\HistoryController::class, 'index'])->name('history.show');

// Theme Routes
Route::get('/themes/{id}', [App\Http\Controllers\ThemeController::class, 'show'])->name('themes.show');
Route::post('/themes/{theme}/subscribe', [App\Http\Controllers\ThemeController::class, 'subscribe'])->name('themes.subscribe');
Route::post('/themes/{themeId}/unsubscribe/{userId}', [App\Http\Controllers\ThemeController::class, 'unsubscribeUser'])->name('responsable.unsubscribe');
Route::post('/themes/store', [App\Http\Controllers\ThemeController::class, 'store'])->name('themes.store'); // For creating themes
Route::delete('/themes/{theme}', [App\Http\Controllers\ThemeController::class, 'destroy'])->name('themes.destroy'); // For deleting themes
Route::get('/themes', [App\Http\Controllers\ThemeController::class, 'index'])->name('themes.index');
Route::delete('/themes/articles/{articleId}', [App\Http\Controllers\ThemeController::class, 'deleteArticle'])->name('themes.articles.delete');



// Article Routes
Route::post('/articles/store', [App\Http\Controllers\ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles/{id}', [App\Http\Controllers\ArticleController::class, 'show'])->name('articles.show');
Route::post('/articles/{id}/rate', [App\Http\Controllers\ArticleController::class, 'rate'])->name('articles.rate');
Route::post('/articles/{id}/approve', [DashboardController::class, 'approve'])->name('articles.approve');
Route::post('/articles/{id}/reject', [DashboardController::class, 'reject'])->name('articles.reject');
Route::post('/articles/{id}/publish', [DashboardController::class, 'publish'])->name('articles.publish');
Route::delete('/dashboard/articles/{id}', [DashboardController::class, 'deleteArticle'])->name('dashboard.articles.delete');
Route::post('/articles/bulk-action', [ArticleController::class, 'bulkAction'])->name('articles.bulkAction');

Route::delete('/articles/{article}', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('articles.destroy');
Route::post('/articles/comment/{commentId}/delete', [App\Http\Controllers\ArticleController::class, 'deleteComment'])->name('articles.comment.delete');




// User Management Routes
Route::post('/users/{id}/delete', [App\Http\Controllers\DashboardController::class, 'deleteUser'])->name('editeur.delete');
// In your routes/web.php file
Route::get('/user-details/{userId}', [App\Http\Controllers\DashboardController::class, 'getUserDetails'])->name('user.details');



Route::get('/suggestions', [SuggestionController::class, 'index'])->name('suggestions.index');



Route::post('/articles/{id}/favorite', [ArticleController::class, 'favorite'])->name('articles.favorite');
Route::post('/articles/{id}/unfavorite', [ArticleController::class, 'unfavorite'])->name('articles.unfavorite');

// Numero Routes
Route::post('/numeros/store', [NumeroController::class, 'store'])->name('numeros.store');
Route::get('/numero/{id}/articles', [NumeroController::class, 'getArticlesByNumero'])->name('numero.articles');
Route::post('/numeros/{id}/publish', [NumeroController::class, 'publish'])->name('numeros.publish');
Route::post('/numeros/{id}/unpublish', [NumeroController::class, 'unpublish'])->name('numeros.unpublish');
Route::get('/numeros/{id}/edit', [NumeroController::class, 'edit'])->name('numeros.edit');
Route::post('/numeros/{id}/update', [NumeroController::class, 'update'])->name('numeros.update');
Route::post('/numeros/{id}/remove-articles', [NumeroController::class, 'removeArticles'])->name('numeros.removeArticles');
Route::delete('/numeros/{id}', [NumeroController::class, 'destroy'])->name('numeros.destroy');
Route::get('/numeros/{id}', [NumeroController::class, 'show'])->name('numeros.show');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

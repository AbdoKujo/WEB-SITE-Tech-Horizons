<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    
    public function handle($request, Closure $next)
{
    $user = Auth::user();
    if ($user && (
        $user->type->name === 'Abonné' ||
        $user->type->name === 'Editeur' ||
        str_contains($user->type->name, 'Responsable')
    )) {
        return $next($request);
    }


    return redirect()->route('unauthorized'); // Or throw an exception
}


}


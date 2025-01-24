<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
{
    if (!Auth::check()) {
        dd('Потребителят не е логнат');
    }

    $user = Auth::user();

    if (!$user->roles()->where('name', $role)->exists()) {
        dd('Нямате тази роля');
    }

    return $next($request);
}

}



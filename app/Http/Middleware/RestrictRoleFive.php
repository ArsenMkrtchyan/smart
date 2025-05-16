<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictRoleFive
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        // если залогинен, и его роль = 5, и он НЕ на странице monitoring
        if ($user && $user->role_id == 5 && ! $request->is('monitoring*')) {
            abort(403, 'Доступ запрещён');
        }

        return $next($request);
    }
}

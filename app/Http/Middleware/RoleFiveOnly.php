<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleFiveOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        // если не залогинен или не role_id = 5
        if (! $user || $user->role_id != 5) {
            abort(403, 'Доступ запрещён');
        }

        return $next($request);
    }
}

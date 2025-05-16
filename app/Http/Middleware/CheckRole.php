<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  int|string  $role  // сюда придёт то, что вы передадите в middleware
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // если нет аутентифицированного пользователя — редирект на логин
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // проверяем по числовому ID роли
        if (is_numeric($role)) {
            if ($user->role_id != (int)$role) {
                abort(403, 'У вас нет доступа к этому разделу.');
            }
        }
        // или по имени роли, если вы хотите так
        else {
            if (!$user->role || $user->role->name !== $role) {
                abort(403, 'У вас нет доступа к этому разделу.');
            }
        }

        return $next($request);
    }
}

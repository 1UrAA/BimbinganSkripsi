<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Superadmin bypass
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized access. You do not have the required role.');
    }
}

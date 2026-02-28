<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $account = auth()->user();

        // If no account or role doesn't match → 403
        if (!$account || $account->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
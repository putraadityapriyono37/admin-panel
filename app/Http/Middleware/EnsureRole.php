<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin || $admin->role !== $role) {
            abort(403);
        }

        return $next($request);
    }
}
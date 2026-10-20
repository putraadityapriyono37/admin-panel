<?php

namespace App\Http\Middleware;

use App\Models\Microsite;
use App\Support\CurrentMicrosite;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMicrositeAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $admin = Auth::guard('admin')->user();
        $param = $request->route('microsite');

        $microsite = $param instanceof Microsite
            ? $param
            : Microsite::where('slug', $param)->firstOrFail();

        abort_unless($admin && $admin->canAccessMicrosite($microsite->id), 403);

        app(CurrentMicrosite::class)->set($microsite);

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->role !== 'admin') {
            if ($request->expectsJson()) {
                abort(403, 'Unauthorized.');
            }

            return redirect()->route('admin.login')
                ->with('error', 'Akun ini tidak memiliki akses admin.');
        }

        return $next($request);
    }
}

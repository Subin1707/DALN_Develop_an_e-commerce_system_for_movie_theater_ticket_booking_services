<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        // ✅ CHỈ CHO STAFF
        if (Auth::user()->role !== 'staff') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

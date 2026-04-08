<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SessionAuth
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! session('user_id')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;

class APIMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->token) {
            \JWTAuth::parseToken()->authenticate();
        }
        return $next($request);
    }
}

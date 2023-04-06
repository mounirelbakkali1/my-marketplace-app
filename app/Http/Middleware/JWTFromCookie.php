<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Support\Facades\Auth;
use function dd;


class JWTFromCookie extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jwt = $request->cookie('jwt');
        if ($jwt) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
            Auth::shouldUse('api');
        }
        return $next($request);
    }
}

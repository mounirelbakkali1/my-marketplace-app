<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTFromCookie
{
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->cookie('jwt');

        if ($jwt) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
            return response()->json(['message' => 'Authorized','token'=>$jwt], 200);
        }
        else{
            return response()->json(['message' => 'Unauthorized----'], 401);
        }
        return $next($request);
    }
}

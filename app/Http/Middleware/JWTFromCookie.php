<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use function dd;

class JWTFromCookie
{
    public function handle(Request $request, Closure $next): Response
    {

        $jwt = $request->cookie('jwt');
        if ($jwt) {
            $request->headers->set('Authorization', implode(' ', ['Bearer', $jwt]));
            //dd($request->headers->all());
        }
        else{
            return response()->json(['message' => 'Unauthorized :(  '], 401);
        }
        return $next($request);
    }
}

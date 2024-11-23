<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JWTToken::VerifyToken($token);
        if($result=="unauthorized"){
            return response()->json(['error' => 'Unauthorized'], 401);
        }else{
            $request->headers->set('email',$result->userEmail);
            $request->headers->set('token',$result->userID);
            return $next($request);
        }
    }
}

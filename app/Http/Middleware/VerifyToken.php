<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\Events\TokenAuthenticated;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->token;
            if($token){
                $user = JWTAuth::parseToken()->authenticate();
            }
        } catch (\Exception $e) {
            if($e instanceof TokenInvalidException){
                return response()-> json(['msg' => 'token is invalid']);//this will be printed when the the user logged out 
            }else if ($e instanceof TokenExpiredException){
                return response()->json(['msg' => 'token is expired']);
            }else{
                return response()->json(['msg' => 'token not provided']);
            }
        }
        return $next($request);
    }
}

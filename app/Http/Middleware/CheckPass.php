<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPass
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($$request->api_password != env("API_PASSWORD","qNQbdn98q3f642S2r47msD7fGr8pGtuksH8kuGxteEeCbaF8FI")){
            return response()->json(['msg' => 'Unauthenticated']);
        }
        return $next($request);
    }
}

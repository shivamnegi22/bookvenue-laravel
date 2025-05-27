<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        
        $previousUrl =  URL::current();
        
        if (Auth::check() && $request->user()->authorizeRoles($roles)) {
            return $next($request);
        }
        
        return redirect()->route('login')->with([ 'previous_url' => $previousUrl ]);
    }
}

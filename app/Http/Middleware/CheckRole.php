<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles)
    {

        if($request->user() == null) {
            return redirect()->route('/');
        }

        if ($request->user()->role !=='admin') {
            return redirect()->route('profile');
        }

        return $next($request);
    //     if(in_array($request->user()->role,$role)){
    //         return $next($request);  
    //     }
    //     return redirect('/');
    // }
}
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::check()) {
           if(Auth::user()->roles == 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }


        if (Auth::check()) {
           if(Auth::user()->roles == 'user') {
                return redirect()->route('user.hotline');
            }
        }


        return $next($request);
    }
}

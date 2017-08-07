<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Obtain token from storage
        $token = $request->session()->get('token', 'noToken');
        // continue with request if token not empty
        if ($token != 'noToken') {
            return $next($request);
        }
        // return to login if token doesn't exist
        return redirect('login');
    }
}

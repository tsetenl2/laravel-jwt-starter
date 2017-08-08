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
        $token = $request->session()->get('token', null);
        // Continue with request if token exists
        if ($token != null) {
            return $next($request);
        }
        // Else redirect to login
        return redirect('login');
    }
}

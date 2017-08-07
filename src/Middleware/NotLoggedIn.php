<?php

namespace App\Http\Middleware;

use Closure;

class NotLoggedIn
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
        // if not logged in go to login page
        if ($token == 'noToken') {
            return $next($request);
        }
        // stay on the same page
        return redirect('home');
    }
}

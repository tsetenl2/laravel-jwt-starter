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
        $token = $request->session()->get('token', null);
        // Redirect to login if token doesn't exist
        if ($token == null) {
            return $next($request);
        }
        // Stay on the same page
        return redirect('home');
    }
}

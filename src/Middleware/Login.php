<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class Login
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
        // username and password validation rule
        $rules = [
            'email' => 'required|max:25',
            'password' => 'required|max:25',
        ];
        $v = Validator::make(Input::all(), $rules);
        if ($v->fails()) {
            // If validation fails then the errors are flashed
            Input::flash();
            // return to login page with errors
            return Redirect::to('login')
                ->withInput()
                ->withErrors($v->messages());
        }
        // Send user data to auth server and check response code
        $client = new Client();
        $result = $client->post(env('AUTH_URL'), [
            'json' => [
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            ],
        ]);
        $response = (array) json_decode($result->getBody());
        $response = $response['response'];
        $status_code = $response->status_code;
        // Check for successful login
        if ($status_code == env("SUCCESS_STATUS_CODE")) {
            $token = $response->data->token;
            // You should check the decoded token here for additional data relevant to authentication
            $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $decoded_array = (array) $decoded;
            $accounts = $decoded_array['accounts'];
            $hasPermissions = true;
            if ($hasPermissions) {
                // Store token in session with expiry se
                session(['token' => $token]);
                return $next($request);
            }

            return Redirect::to('login')
                ->withErrors('Do not have permissions');
        }
        // authentication fails, so back to login page with errors
        return Redirect::to('login')
            ->withErrors('Incorrect login details');
    }
}

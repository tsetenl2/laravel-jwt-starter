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
        // Fields that match your auth login setup
        $userInput = [
            'email' => Input::get('email'),
            'password' => Input::get('password'),
        ];
        // Validation rules for login input
        $rules = [
            'email' => 'required|max:25',
            'password' => 'required|max:25',
        ];
        $v = Validator::make(Input::all(), $rules);
        if ($v->fails()) {
            // Validation errors are flashed and user is redirected back to login page
            Input::flash();
            return Redirect::to('login')
                ->withInput()
                ->withErrors($v->messages());
        }

        // Post user data to auth server and check response code
        $client = new Client();
        $result = $client->post(env('AUTH_URL'), [
            'json' => $userInput,
        ]);
        $response = (array) json_decode($result->getBody());
        $response = $response['response'];
        $status_code = $response->status_code;

        // Check for successful login
        if ($status_code == env("STATUS_CODE")) {
            $token = $response->data->token;

            // You should check the decoded token here for additional data relevant to authentication
            $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $decoded_array = (array) $decoded;
            $hasPermissions = true;

            if ($hasPermissions) {
                // Store token in session
                session(['token' => $token]);
                return $next($request);
            }

            return Redirect::to('login')
                ->withErrors('Do not have permissions');
        }
        // Redirect to login page on authentication failure
        return Redirect::to('login')
            ->withErrors('Incorrect login details');
    }
}

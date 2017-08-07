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
            // username or password missing
            // validation fails
            // used to retain input values
            Input::flash();
            // return to login page with errors
            return Redirect::to('login')
                ->withInput()
                ->withErrors($v->messages());
        }
        // send user data to auth server
        // check response.data.response.status_code === 1033
        // verify token payload has administrator as one of the roles
        $client = new Client(); //GuzzleHttp\Client
        $result = $client->post(env('AUTH_URL'), [
            'json' => [
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            ],
        ]);
        $response = (array) json_decode($result->getBody());
        $response = $response['response'];
        $status_code = $response->status_code;
        //successful login
        if ($status_code == 1033) {
            $token = $response->data->token;
            // decode token to obtain account info
            $decoded = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $decoded_array = (array) $decoded;
            $accounts = $decoded_array['accounts'];
            $hasPrivilege = collect($accounts)->filter(function ($account) {
                return $account->role->title == 'Account Manager' || $account->role->title == 'Account Manager Admin' ||
                $account->role->title == 'Administrator';
            })->isNotEmpty();
            // authentication success, enters home page
            if ($hasPrivilege) {
                // store token in session with expiry of 2 hours
                session(['token' => $token]);

                return $next($request);
            }

            return Redirect::to('login')
                ->withErrors('Do not have admin privileges');
        }
        // authentication fails, so back to login page with errors
        return Redirect::to('login')
            ->withErrors('Incorrect login details');
    }
}

# laravel-jwt-starter

In a microservice oriented architecture, a client component will communicate with set of microservices where interactions need to be authenticated and authorized. Usually, the users of these microservices will authenticate using the same API in this system. Often, the creation of a login page and authentication middleware will need to be replicated in each of these microservices.

Given a Laravel application, this package will create a generic login with relevant jwt middleware to authenticate the user into your authentication API. This Laravel boilerplate can be added to an existing or new project with minimal configuration. It publishes the respective views, css, and middleware into your project. These can be configured to your needs.

### Installation
To install this package you will need:
- Laravel 5
- PHP 5.4 +

Also, you will need to first install these packages
- Forms & HTML - [laravelcollective/html](https://laravelcollective.com/docs/master/html)
    - ``` composer require "laravelcollective/html" ```
    - Update service providers and aliases in `config/app.php` file
    -  ``` php
       'providers' => [
            // ...
            Collective\Html\HtmlServiceProvider::class,
            // ...
        ],
        ...
        'aliases' => [
            // ...
            'Form' => Collective\Html\FormFacade::class,
            'Html' => Collective\Html\HtmlFacade::class,
            // ...
        ],
        ```
- PHP-JWT - [firebase/php-jwt](https://github.com/firebase/php-jwt)
    - ``` composer require firebase/php-jwt ```
- Guzzle - [guzzlehttp/guzzle](http://docs.guzzlephp.org/en/stable/overview.html#installation)
    - ``` composer require guzzlehttp/guzzle ```

This project integrates these three packages for a form builder, token decoder, and HTTP Client. These packages have numerous features that will help with development over time by reducing overhead.

#### 1) Environment variables

Set your authentication API endpoint, JWT secret, and successful login response code
in your `.env` file:
```
AUTH_URL=
JWT_SECRET=
STATUS_CODE=
```

#### 2) Service Provider

Register this package's Service Provider by adding it to the `providers`
section of your `config/app.php` file:

```php
   'providers' => [
       // ... other providers omitted
       TLX3\LaravelJWTStarter\LaravelJWTStarterServiceProvider::class,
   ],
```

#### 3) Middleware
Update $routeMiddleware in `app/Http/Middleware/kernel.php` file with the additional middleware added:

```php
    protected $routeMiddleware = [
        // ... other middleware omitted
        'checkToken' => \App\Http\Middleware\CheckToken::class,
        'notLoggedIn' => \App\Http\Middleware\NotLoggedIn::class,
        'logout' => \App\Http\Middleware\Logout::class,
        'login' => \App\Http\Middleware\Login::class,
    ];
```

#### 4) Routes
Update `routes/web.php` with these routes. You can modify and change these routes to fit your project, I've added a filler home page as a landing page after logging in:
```php
    Route::get('login', function () {
        return view('login');
    })->middleware('notLoggedIn');

    Route::post('authenticate', function () {
        return View::make('home');
    })->middleware('login');

    // routes that require user to have been authenticated
    Route::group(['middleware' => 'checkToken'], function () {
        Route::get('home', function () {
            return View::make('home');
        });

        Route::get('logout', function () {
            return View::make('login');
        })->middleware('logout');
    });
```
### Usage
After installation run:
```
artisan vendor:publish --provider="TLX3\LaravelJWTStarter\LaravelJWTStarterServiceProvider"
```
You can now go to `/login` and attempt to login and access protected routes as set prior.
Alongside the routes, you will probably want to modify both `views/login.blade.php` and `app/Http/Middleware/Login.php` to fit your application logic. The authentication inputs are set here along with the .env variables names that you can customize. You should also modify Login and CheckToken middleware to decode the token for neccessary payload items if needed.

License
----

MIT

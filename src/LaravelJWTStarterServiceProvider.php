<?php

namespace TLX3\LaravelJWTStarter;

use Illuminate\Support\ServiceProvider;

class LaravelJWTStarterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/views' => app_path('resources/views/'),
        ]);
        $this->publishes([
            __DIR__ . '/css' => public_path('css'),
        ]);
        $this->publishes([
            __DIR__ . '/Middleware' => app_path('Http/Middleware'),
        ]);
    }
}

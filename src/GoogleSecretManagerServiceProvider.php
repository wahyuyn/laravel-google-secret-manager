<?php

namespace Vendor\GoogleSecretManagerServiceProvider;

use Illuminate\Support\ServiceProvider;

class GoogleSecretManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Boot methods
    }

    public function register()
    {
        // Register bindings
        $this->app->singleton('google.secret.manager', function ($app) {
            return new GoogleSecretManager();
        });
    }
}

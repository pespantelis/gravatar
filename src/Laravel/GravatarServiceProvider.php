<?php

namespace Peslis\Gravatar\Laravel;

use Illuminate\Support\ServiceProvider;

class GravatarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('gravatar.php')
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gravatar', function()
        {
            return new \Peslis\Gravatar\Factory(config('gravatar'));
        });
    }
}

<?php

namespace Joeystowe\MsGraphApi;

use Illuminate\Support\ServiceProvider;
use Joeystowe\MsGraphApi\Http\Middleware\MicrosoftAuthMiddleware;

class MsGraphApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'ms-graph-api');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');


        \Illuminate\Support\Facades\Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $e = new \SocialiteProviders\Azure\AzureExtendSocialite();
            $e->handle($event);
        });

        $router = $this->app->make(\Illuminate\Routing\Router::class);
        $router->aliasMiddleware('ms-auth', MicrosoftAuthMiddleware::class);

        if ($this->app->runningInConsole()) {
            // $this->publishes([
            //     __DIR__ . '/../config/config.php' => config_path('ms-graph-api.php'),
            // ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/ms-graph-api'),
            ], 'views');*/

            // Publishing assets.
            $this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/ms-graph-api'),
            ], 'assets');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/ms-graph-api'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'ms-graph-api');

        // Register the main class to use with the facade
        $this->app->singleton('ms-graph-current-user-api', function () {
            return new MsGraphCurrentUserApi;
        });

        $this->app->singleton('logged-in-user', function () {
            return new \Joeystowe\MsGraphApi\LoggedInUser;
        });
    }
}

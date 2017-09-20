<?php

namespace Jakjr\Keeper;

use Illuminate\Support\ServiceProvider;

class KeeperSeviceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('keeper', function($app, $params)
        {
            $context = isset($params[0]) ? $params[0] : $app->request->path();

            return new Keeper($context, app('Illuminate\Session\Store'));
        });

        $this->app['router']->aliasMiddleware('keep.filters', Middleware\KeepFilters::class);
    }
}

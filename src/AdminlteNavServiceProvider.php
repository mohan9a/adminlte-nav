<?php

namespace Mohan9a\AdminlteNav;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class AdminlteNavServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'adminltenav');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->registerRoutes();

        $this->registerHelpers();

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminltenav');
        
        if ($this->app->runningInConsole()) {
            
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('adminltenav.php'),
            ], 'config');

            // Export the migration
            if (! class_exists('CreateMenusAndMenuitemTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_menus_and_menuitem_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_menus_and_menuitem_table.php'),
                    // you can add any number of migrations here
                ], 'migrations');
            }

            
        }
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('adminltenav.prefix'),
            'middleware' => config('adminltenav.middleware'),
        ];
    }

    /**
     * Register helpers file
     */
    public function registerHelpers()
    {
        if (file_exists($file = __DIR__.'/helpers.php'))
        {
            require $file;
        }
    }

}

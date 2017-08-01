<?php

namespace Terranet\Pages;

use App\Page;
use Cviebrock\EloquentSluggable\ServiceProvider as SluggableServiceProvider;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Terranet\Pages\Console\PagesTableCommand;
use Terranet\Pages\Contracts\PagesRepository as PagesContract;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $baseDir = realpath(__DIR__ . '/../../../');
        $local = "{$baseDir}/publishes/routes.php";
        $routes = app_path('Http/Terranet/Pages/routes.php');

        if (!$this->app->routesAreCached()) {
            if (file_exists($routes)) {
                /** @noinspection PhpIncludeInspection */
                require_once $routes;
            } else {
                /** @noinspection PhpIncludeInspection */
                require_once $local;
            }
        }

        // routes
        $this->publishes([$local => $routes], 'routes');

        // resources
        $this->publishes(["{$baseDir}/publishes/Modules" => app_path('Http/Terranet/Administrator/Modules')], 'resources');

        // models
        $this->publishes(["{$baseDir}/publishes/Models" => app_path()], 'models');
    }

    public function register()
    {
        if (!$this->app->getProvider($provider = SluggableServiceProvider::class)) {
            $this->app->register($provider);
        }

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton(PagesContract::class, function () {
            return new PagesRepository(Page::class);
        });

        $this->app->singleton('command.pages.table', function ($app) {
            return new PagesTableCommand($app['files'], $app['composer']);
        });

        $this->commands(['command.pages.table']);
    }
}

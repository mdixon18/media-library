<?php

namespace Mdixon18\MediaLibrary;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Mdixon18\MediaLibrary\Models\Media;
use Mdixon18\MediaLibrary\PathGenerator;

class MediaLibraryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        ini_set( 'memory_limit', '1024M' );
        ini_set( 'max_execution_time', 300 );
        
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }

        $this->registerResources();

        $this->registerConfigs();
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    protected function registerPublishing()
    {
        $this->publishes([
            __DIR__.'/../config/media-library.php' => config_path('media-library.php'),
        ], 'media-library-config');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'media-library-migrations');
    }

    /**
     * Register the package resources such as routes, templates, etc.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->registerRoutes();
    }

    /**
     * Overwrite required packages config in runtime
     * 
     * @return void
     */
    protected function registerConfigs()
    {
        \Config::set('medialibrary.media_model', config('media-library.media_model', Media::class));
        \Config::set('medialibrary.disk_name', config('media-library.disk', 'public'));
        \Config::set('medialibrary.path_generator', config('media-library.path_generator', PathGenerator::class));
        \Config::set('medialibrary.max_file_size', config('media-library.max_file_size', 1024 * 1024 * 10));
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }

    /**
     * Get the Admin route group configuration array.
     *
     * @return array
     */
    protected function routeConfiguration()
    {
        return [
            'domain' => config('media-library.domain', null),
            'as' => 'media-library.api.',
            'prefix' => 'media-library-api',
            'middleware' => config('media-library.middleware', null),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

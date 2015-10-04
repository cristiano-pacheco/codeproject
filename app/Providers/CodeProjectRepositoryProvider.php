<?php

namespace CodeProject\Providers;

use Illuminate\Support\ServiceProvider;

class CodeProjectRepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('CodeProject\Repositories\ClientRepository',
            'CodeProject\Repositories\ClientRepositoryEloquent');
        
        $this->app->bind('CodeProject\Repositories\ProjectRepository',
            'CodeProject\Repositories\ProjectRepositoryEloquent');
    }
}

<?php

namespace Jeremy379\Toolbox;

use Famousinteractive\Toolbox\Commands\Toolbox;
use Illuminate\Support\ServiceProvider;

class ToolboxServiceProvider extends ServiceProvider
{
    protected $commands = [
        Toolbox::class
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}

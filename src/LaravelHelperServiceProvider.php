<?php

namespace LabKito\LaravelHelper;

use Illuminate\Support\ServiceProvider;

class LaravelHelperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        foreach (glob(__DIR__ . '/Helpers/*.php') as $filename) {
            require_once $filename;
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                \LabKito\LaravelHelper\Console\InstallCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/utils' => base_path(),
            ], 'utils');

            // $this->publishes([
            //     __DIR__.'/../resources/js' => resource_path('vendor/mypackage'),
            // ], 'mypackage-js');
        }
    }

    public function register()
    {
        //
    }
}

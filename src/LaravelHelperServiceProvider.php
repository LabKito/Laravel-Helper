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
                __DIR__.'/Resources' => resource_path(),
            ], 'labkito-frontend');
        }
    }

    public function register()
    {
        //
    }
}

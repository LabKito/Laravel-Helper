<?php

namespace LabKito\LaravelHelper\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'labkito-helper:install';
    protected $description = 'Install package, Inertia dependencies, and custom frontend assets';

    public function handle()
    {
        $this->info('Installing package dependencies via Composer...');
        // $this->runShellCommand('composer require @inertiajs/inertia-laravel');

        $this->info('Installing frontend dependencies via npm...');
        // $this->runShellCommand('npm install @inertiajs/inertia @inertiajs/inertia-vue3 vue@3');

        $this->info('Installing custom package frontend assets...');
        // $this->runShellCommand('npm install your-custom-package');
        $this->info('Publishing package assets...');
        // $this->call('vendor:publish', ['--tag' => 'mypackage-js']);
        $this->info('Installation complete!');
    }

    protected function runShellCommand($command)
    {
        $process = proc_open($command, [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ], $pipes);

        if (is_resource($process)) {
            while ($line = fgets($pipes[1])) {
                echo $line;
            }
            while ($err = fgets($pipes[2])) {
                echo $err;
            }

            proc_close($process);
        }
    }
}

<?php

namespace Labkito\LaravelHelper\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'labkito-helper:install';
    protected $description = 'Install package, Inertia dependencies, and custom frontend assets';

    public function handle()
    {
        $this->info('Installing package dependencies via Composer...');
        $this->runShellCommand('composer require inertiajs/inertia-laravel -n');
        $this->runShellCommand('composer require laravel/wayfinder laravel/fortify');

        $this->info('copy all utils from package to projects');
        $this->runShellCommand('rm ' . base_path() . '/vite.config.js');
        $this->runShellCommand('cp -r ' . __DIR__ . '/../Utils/* ' . base_path() .'');

        $this->info('Installing frontend npm dependencies...');
        $this->runShellCommand('npm install');

        $this->info('Installing labkito frontend assets...');
        // $this->runShellCommand('npm install your-custom-package');

        $this->info('Publishing package assets...');
        // $this->call('vendor:publish', ['--tag' => 'labkito-frontend']);

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

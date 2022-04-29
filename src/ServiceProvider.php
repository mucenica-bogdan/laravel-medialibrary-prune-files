<?php

namespace Falcon\MediaLibrary;

use Falcon\MediaLibrary\Console\Commands\Prune;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Prune::class
            ]);
        }
    }
}

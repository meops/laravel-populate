<?php

namespace Meops\Populate;

use Illuminate\Support\ServiceProvider;
use Meops\Populate\Commands\Populate;

class PopulateServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if($this->app->runningInConsole()) {
            $this->commands([
                Populate::class,
            ]);
        }
    }
}
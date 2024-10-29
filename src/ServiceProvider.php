<?php

namespace Meops\Populate;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Meops\Populate\Commands\Populate;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        if($this->app->runningInConsole()) {
            $this->commands([
                Populate::class,
            ]);
        }
    }
}
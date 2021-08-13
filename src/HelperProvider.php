<?php

namespace Zwx\Helper;

use Illuminate\Support\ServiceProvider;

class HelperProvider extends ServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->singleton('helperFunc', function () {
            return new Helper();
        });
    }
}

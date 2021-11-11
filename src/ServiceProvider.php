<?php

namespace Silversbro\SiteParser;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/config.php', 'site_parser');

        $this->publishes([
            __DIR__.'/config.php' => config_path('site_parser.php'),
        ], 'site_parser_config');
    }
}
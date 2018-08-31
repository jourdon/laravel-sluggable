<?php

namespace Jourdon\Sluggable;

use Illuminate\Support\ServiceProvider as BaseServiceProvider; 

class ServiceProvider extends BaseServiceProvider
{
    protected $commands = [
        Console\JourdonMakeSlug::class,
        Console\MakeSlugCache::class,
    ];

    public function boot()
    {

    }

    public function register()
    {
        $this->commands($this->commands);
    }

}

<?php

namespace Khapu\CurlPlatform\Providers;

use Illuminate\Support\ServiceProvider;

class PackageBaseServiceProvider extends ServiceProvider 
{
    public function register()
    {
        
    }

    public function boot()
    {
        dd('hello');   
    }

}
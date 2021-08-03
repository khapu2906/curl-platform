<?php

namespace Khapu\CurlPlatform;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
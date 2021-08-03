<?php

namespace Khapu\CurlPlatform\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;

class PackageBaseServiceProvider extends ServiceProvider 
{

    protected $_modulePath = __DIR__.'/../';
    
    protected $_moduleConfig = 'config/platform.php';

    protected $_moduleRoute  =  'router/web.php';

    protected $moduleName = '';


    public function register()
    {
        $this->mergeConfigFrom($this->_modulePath . $this->_moduleConfig, 'curlplatform');
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->_modulePath . $this->_moduleConfig => config_path('platform.php'),
            ], 'config');
        }
        if (File::exists($this->_modulePath . $this->_moduleRoute)) {
            $this->loadRoutesFrom($this->_modulePath . "$this->_moduleRoute");
        }
        dd(1);
        
    }

}
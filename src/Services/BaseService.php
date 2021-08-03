<?php

namespace Khapu\CurlPlatform\Services;

class BaseService 
{
    protected $host;

    protected $componentUrl;

    protected $path;

    protected $prefixURL = '';

    protected $url = '';

    protected $token;

    protected $configs;

    protected $timeOut = 30;

    /**
     * BaseService constructor.
     * @param string $configName
     * @param int $timeout
     * @throws ErrorException
        */
    
    public function __construct(string $configName, int $timeOut)
    {
        $configName = 'platform.' . $configName;
        $this->configs = config($configName);
        // $this->host = 
       
    }

    public function host()
    {

    }

    public function get()
    {

    }

    public function post()
    {

    }

    public function error()
    {

    }

    public function getConfig()
    {
        return $this->configs;
    }
}
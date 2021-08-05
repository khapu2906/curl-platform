<?php

namespace Khapu\CurlPlatform\Services\Reports;

use Khapu\CurlPlatform\Services\Reports\PlatformService;

class GoogleService 
{
    private $_config;

    private $_platformService;

    public function __construct()
    {
        $this->_platformService = new PlatformService('google', 30);
    }

    public function getExchangeToken(array $fields)
    {
        $response = $this->_platformService->host('account')
                                        ->version('v2')
                                        ->slug('auth')
                                        ->fields($fields)
                                        ->get();
        return $response;
    }

    public function getAccessToken(array $param)
    {
        $response = $this->_platformService->host('auth')
                                        ->slug('token')
                                        ->param($param)
                                        ->post();
        return $response;
    }
    
}

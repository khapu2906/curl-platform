<?php

namespace Khapu\CurlPlatform\Services\Reports;

use Khapu\CurlPlatform\Services\Reports\PlatformService;

class FacebookService 
{
    private $_config;
    
    private $_platformService;

    public function __construct()
    {
        $this->_platformService = new PlatformService('facebook',30);

    }

    public function getInsight(array $params, array $tokens, array $fields)
    {
        $response = $this->_platformService->fields($fields)
                                        ->slug('insights', $params)
                                        ->token($tokens)
                                        ->get();
        return $response;
    }

    public function getAccount(array $params, array $tokens, array $fields)
    {
        $response = $this->_platformService->slug('account', $params)
                                        ->token($tokens)
                                        ->fields($fields)
                                        ->get();
        return $response;
    }

    public function getAds(array $params, array $tokens, array $fields)
    {
        $response = $this->_platformService->slug('ads', $params)
                                        ->token($tokens)
                                        ->fields($fields)
                                        ->get();
        return $response;
    }

    public function getLongTimeToken(array $fields)
    {
        $response = $this->_platformService->slug('long_time_token')
                                        ->fields($fields)
                                        ->get();
        return $response;
    }
}
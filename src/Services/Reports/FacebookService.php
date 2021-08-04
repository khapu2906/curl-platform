<?php

namespace Khapu\CurlPlatform\Services\Reports;

use Khapu\CurlPlatform\Services\BaseService;

class FacebookService extends BaseService
{
    private $_config;
    
    private $_baseService;

    public function __construct()
    {
        $this->_baseService = new BaseService('facebook',30);

        $this->_config = $this->_baseService->getConfig();
    }

    public function getInsight($params, $tokens, $fields)
    {
        $response = $this->_baseService->fields($fields)
                                        ->slug('insights', $params)
                                        ->token($tokens)
                                        ->get();
        return $response;
    }

    public function getAccount($params, $tokens, $fields)
    {
        $response = $this->_baseService->slug('account', $params)
                                        ->token($tokens)
                                        ->fields($fields)
                                        ->get();
        return $response;
    }

    public function getAds($params, $tokens, $fields)
    {
        $response = $this->_baseService->slug('ads', $params)
                                        ->token($tokens)
                                        ->fields($fields)
                                        ->get();
        return $response;
    }

    public function getLongTimeToken($fields)
    {
        $response = $this->_baseService->slug('long_time_token')
                                        ->fields($fields)
                                        ->get();
        return $response;
    }
}
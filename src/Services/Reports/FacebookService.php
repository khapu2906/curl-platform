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
        $response = $this->_baseService->getSlug('insights', $params)
                                        ->getToken($tokens)
                                        ->getField($fields)
                                        ->get();
        return $response;
    }

    public function getAccount($params, $tokens, $fields)
    {
        $response = $this->_baseService->getSlug('account', $params)
                                        ->getToken($tokens)
                                        ->getField($fields)
                                        ->get();
        return $response;
    }

    public function getAds($params, $tokens, $fields)
    {
        $response = $this->_baseService->getSlug('ads', $params)
                                        ->getToken($tokens)
                                        ->getField($fields)
                                        ->get();
        return $response;
    }

    public function getLongTimeToken($fields)
    {
        $response = $this->_baseService->getSlug('long_time_token')
                                        ->getField($fields)
                                        ->get();
        return $response;
    }
}
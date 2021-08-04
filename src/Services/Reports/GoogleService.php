<?php

namespace Khapu\CurlPlatform\Services\Reports;

use Khapu\CurlPlatform\Services\BaseService;

class GoogleService extends BaseService
{
    private $_config;

    private $_baseService;

    public function __construct()
    {
        $this->_baseService = new BaseService('google', 30);

        $this->_config = $this->_baseService->getConfig();
    }

    public function getExchangeToken($fields)
    {
        $response = $this->_baseService->host('account')
                                        ->version('v2')
                                        ->slug('auth')
                                        ->fields($fields)
                                        ->get();
        return $response;
    }
    
}

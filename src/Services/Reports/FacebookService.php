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

    public function getDetail()
    {
        $url = $this->_config;
        return $url;
    }
}
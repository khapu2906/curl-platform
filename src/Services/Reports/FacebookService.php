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
        // $this->_baseService->getSlug('insights', ['id' => '0123456789'] );
        // $this->_baseService->getSlug('insights', ['id' => '0123456789']);
        $url = $this->_baseService->getSlug('insights', ['id' => '0123456789'])->get();
        return $url;
    }
}
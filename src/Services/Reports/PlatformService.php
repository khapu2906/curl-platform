<?php

namespace Khapu\CurlPlatform\Services\Reports;

use Khapu\CurlPlatform\Services\BaseService;

class PlatformService extends BaseService
{
    public function __construct(string $platformName, int $timeOut){
        parent::__construct($platformName, $timeOut);
    }
}
    
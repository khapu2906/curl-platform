<?php

namespace Khapu\CurlPlatform\Services\Reports;

use Khapu\CurlPlatform\Services\BaseService;
use Khapu\CurlPlatform\Services\PlatformInterface;

final class PlatformService extends BaseService implements PlatformInterface
{
    public function __construct(string $platformName, int $timeOut){
        parent::__construct($platformName, $timeOut);
    }
}
    
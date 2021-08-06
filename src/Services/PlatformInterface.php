<?php

namespace Khapu\CurlPlatform\Services;

interface PlatformInterface
{
    /**
     * @param string $host
     * @return mixed
     */
    public function host(string $host);

    /**
     * @param string $version
     * @return mixed
     */
    public function version(string $version);

    /** 
     *  @param array $token
     *  @return mixed
     * */ 
    public function token($token = []);

    public function slug(string $slug, array $param = []);
    
    /** 
     *  @param array $query
     *  @return mixed
     * */ 
    public function query(array $query = []);

    /** 
     *  @param array $param
     *  @return mixed
     * */ 
    public function param(array $param = []);

    public function get();

    public function post();

    public function error($data = [], $method, $code = 404, $message = null);
 
}
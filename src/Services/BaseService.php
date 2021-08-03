<?php

namespace Khapu\CurlPlatform\Services;
use ErrorException;
class BaseService 
{
    protected $host;

    protected $slug;

    protected $path;

    protected $prefixURL = 'https';

    protected $url = '';

    protected $token;

    protected $configs;

    protected $timeOut = 30;

    /**
     * BaseService constructor.
     * @param string $configName
     * @param int $timeout
     * @throws ErrorException
        */
    
    public function __construct(string $configName, int $timeOut)
    {
        if ($configName == null) {
            throw new ErrorException('Config not found!');
        }
        $configName = 'platform.' . $configName;
        $this->configs = config($configName);   
        $this->host = $this->configs['host'];
        $this->path = $this->prefixURL ."://" . $this->host . '/' .  $this->configs['version'];

    }

    public function getSlug(string $slug, array $param = [])
    {
        if ($slug == null) {
            throw new ErrorException('Slug is null!');
        } else {
            if (!array_key_exists($slug, $this->configs['slugs'])) {
                throw new ErrorException('Slug is not found!');
            }
            $this->slug = $this->configs['slugs'][$slug];
            if (substr_count($this->slug, '{') != count($param) 
                || substr_count($this->slug, '}') != count($param)) {
                throw new ErrorException('Slug!');
            }
            foreach ($param as $key => $value) {
                $strSearch = '{' . $key . '}';
                $this->slug = str_replace($strSearch, $value, $this->slug);
            }
        }
        return $this;
    }

    public function url()
    {
        return $this->path . '/' . $this->slug;
    }

    public function get($query = [])
    {
        
    }

    public function post()
    {

    }

    public function error()
    {

    }

    public function getConfig()
    {
        return $this->configs;
    }
}
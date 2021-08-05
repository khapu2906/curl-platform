<?php

namespace Khapu\CurlPlatform\Services;
use ErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
class BaseService 
{
    protected $host;

    protected $slug;

    protected $path;

    protected $version;

    protected $prefixURL = 'https';

    protected $url = '';

    protected $token = [];

    protected $configs;

    protected $options = [];

    protected $guzzle;

    protected $timeOut = 30;

    /**
     * BaseService constructor.
     * @param string $configName
     * @param int $timeout
     * @throws ErrorException
     */
    public function __construct(string $configName, int $timeOut)
    {
        if ($timeOut > 0) {
            $this->timeOut = $timeOut;
        }
        if ($configName == null) {
            throw new ErrorException('Config not found!');
        }
        $configName = 'platform.' . $configName;
        $this->guzzle = new Client([
            'timeout' => $this->timeOut,
            'verify' => false,
        ]);
        $this->configs = config($configName);   
        if (empty($this->configs['host'])) {
            throw new ErrorException('Host is NULL!');
        }
        $this->host = current($this->configs['host']);
        $this->version = (!empty($this->configs['version']))
            ? current($this->configs['version']) : null;
        $this->options = [
                            'headers' => []
                           ];
    }

    /** 
     *  @param string $host
     *  @return mixed
     * */ 
    protected function setHost(string $host = null) : void
    {
        $this->host = (!empty($host)) ? $this->configs['host'][$host] : $this->host;
    }

    protected function getHost()
    {
        return $this->host;
    }

    /** 
     *  @param string $version
     *  @return mixed
     * */
    protected function setVersion(string $version = null): void
    {
        $this->version = (!empty($version)) ? $version : $this->version;
    }

    protected function getVersion()
    {
        return $this->version;
    }

    protected function setPath() : void
    {
        $this->path = $this->prefixURL . "://" . $this->host;
        $this->path = ($this->version !== null)
            ? $this->path . '/' .  $this->version
            : $this->path;
    }

    protected function getPath()
    {
        return $this->path;
    }

    protected function setUrl() : void
    {
        $this->url = $this->path . '/' . $this->slug;
    }

    protected function getUrl()
    {
        return $this->url;
    }

    /** 
     *  @param array $token
     * */ 
    public function setToken(array $token = []) : void
    {
        $this->token = (!empty($token)) ? $token : $this->token;
    }

    protected function getToken()
    {
        return $this->token;
    }

    /** 
     *  @param array $option
     * */ 
    protected function setOptions(array $options = []) : void 
    {
        $this->options = (!empty($options)) ? $options : $this->options;
    }

    protected function getOptions()
    {
        return $this->options;
    }

    /**
     * @param string $host
     * @return mixed
     */
    public function host(string $host)
    {
        if (!array_key_exists($host, $this->configs['host'])) {
            throw new ErrorException('Host not found!');
        }
        $this->host = $this->configs['host'][$host];
        return $this;
    }

    /**
     * @param string $version
     * @return mixed
     */
    public function version(string $version)
    {
        if (!in_array($version, $this->configs['version'])) {
            throw new ErrorException('Version not found!');
        }
        $this->version = $version;
        return $this;
    }
  
    /** 
     *  @param array $token
     *  @return mixed
     * */ 
    public function token($token = [])
    {
        $this->token = array_merge_recursive_distinct($this->token, $token);
        return $this;
    }

    public function slug(string $slug, array $param = [])
    {
        if ($slug == null) {
            throw new ErrorException('Slug is NULL!');
        } else {
            if (!array_key_exists($slug, $this->configs['slugs'])) {
                throw new ErrorException('Slug not found!');
            }
            $this->slug = $this->configs['slugs'][$slug];
            if (
                substr_count($this->slug, '{') != count($param)
                || substr_count($this->slug, '}') != count($param)
            ) {
                throw new ErrorException('Slug is error!');
            }
            foreach ($param as $key => $value) {
                $strSearch = '{' . $key . '}';
                $this->slug = str_replace($strSearch, $value, $this->slug);
            }
        }
        return $this;
    }

    /** 
     *  @param array $options
     *  @return mixed
     * */ 
    public function fields(array $fields = []) 
    {
        $this->_formatOption($fields, 'query');
        return $this;
    }

    public function param(array $param = [])
    {
        $this->_formatOption($param, 'form_params');
        return $this;
    }

    // public function fields() 

    protected function _formatOption(array $fields = [], string $type = null) : void
    {
        if ($type != null) {
            $fields[$type] = $fields;
        }
        $this->options = array_merge_recursive_distinct($this->options, $fields);
        if (!empty($this->token)) {
            $header = [];
            foreach ($this->token as $k => $v ) {
                if ($k == 'access_token') {
                    $k = 'Authorization';
                    $v = 'Bearer ' . $v;
                }
                $header = [
                    $k => $v
                ];
            }
            $this->options['headers'] = $header;
        }
    }

    public function get()
    {
        $this->stream();
        $response = (object)[];
        try {
            $res = $this->guzzle->get($this->url, $this->options);
            $content = $res->getBody()->getContents();
            $response = json_decode($content);
          
            if (isset($response->code) && $response->code != 200 && isset($response->message) && $response->message) {
                $this->error(['url' => $this->url], 'GET', $response->code, $response->message);
            }
        } catch (ClientException $e) {
            $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
        } catch (ServerException $e) {
            $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
        } catch (RequestException $e) {
            $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
        } catch (ErrorException $e) {
            $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
        }
        return $response;
    }

    public function post()
    {
        $response = (object)[];
        $this->stream();
        try {
            $res = $this->guzzle->post($this->url, $this->options);
            $content = $res->getBody()->getContents();
            $response = json_decode($content);
            if (isset($response->code) && $response->code != 200 && isset($response->message) && $response->message) {
                $this->error(['url' => $this->url], 'POST', $response->code, $response->message);
            }
        } catch (ClientException $e) {
            $this->error(['url' => $this->url], 'POST', $e->getCode(), $e->getMessage());
        } catch (ServerException $e) {
            $this->error(['url' => $this->url], 'POST', $e->getCode(), $e->getMessage());
        } catch (RequestException $e) {
            $this->error(['url' => $this->url], 'POST', $e->getCode(), $e->getMessage());
        } catch (ErrorException $e) {
            $this->error(['url' => $this->url], 'POST', $e->getCode(), $e->getMessage());
        }

        return $response;
    }

    public function error($data = [], $method, $code = 404, $message = null)
    {
        // $user = Auth::user();
        // $username = $user ? $user->username . ' [' . $user->email_address . ']' : '';
        $data = array_merge([
            'method' => $method,
            'uri' => null,
            'options' => [],
            'response' => null,
        ], $data);
        // $url = isset($data['url']) ? $data['url'] : null;
        $method = $data['method'];
        // $options = $data['options'];
        $response = $data['response'];
        return $response;
    }

    public function getConfig()
    {
        return $this->configs;
    }

    protected function stream() : void
    {
        $this->setHost();
        $this->getHost();
        $this->setVersion();
        $this->getVersion();
        $this->setPath();
        $this->getPath();
        $this->setUrl();
        $this->getUrl();
        $this->setToken();
        $this->getToken();
        $this->setOptions();
        $this->_formatOption();
        $this->getOptions();
    }
}
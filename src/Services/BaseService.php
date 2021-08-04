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

    protected $prefixURL = 'https';

    protected $url = '';

    protected $token;

    protected $configs;

    protected $options;

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
        $this->host = $this->configs['host'];
        $this->setPath();
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
                throw new ErrorException('Slug is error!');
            }
            foreach ($param as $key => $value) {
                $strSearch = '{' . $key . '}';
                $this->slug = str_replace($strSearch, $value, $this->slug);
            }
            $this->setUrl();
        }
        return $this;
    }

    protected function setPath() : void
    {
        $this->path = $this->prefixURL . "://" . $this->host . '/' .  $this->configs['version'];
    }

    protected function setUrl() : void
    {
        $this->url = $this->path . '/' . $this->slug;
    }
    /** 
     *  @param array $token
     *  @return mixed
     * */ 
    public function getToken($token = [])
    {
        $this->token = $token;
        return $this;
    }

    /** 
     *  @param array $fields
     *  @return mixed
     * */ 

    public function getField(array $fields = [])
    {
        $this->options = array_merge_recursive([
            'headers' => []
        ], $fields);
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
        return $this;
    }

    public function get()
    {   
        $response = false;
        $curl = curl_init();
        $fields = '';
        foreach ($this->options as $k => $v) {
            if ($k !== 'headers') {
                $fields .= $k . '=' . $v . '&';
            }
        }
        $curlopt_url = $this->url . '?' . $fields;
        $header = $this->options['headers'];
        // dd($header);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $curlopt_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => $this->timeOut,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER =>$header,
        ));

        $response = curl_exec($curl);
        $response = json_decode($response);
        curl_close($curl);
        return $response;
    }

    // public function get()
    // {
    //     try {
    //         $response = false;
    //         $res = $this->guzzle->get($this->url, $this->options);
    //         $content = $res->getBody()->getContents();
    //         $response = json_decode($content);
          
    //         if (isset($response->code) && $response->code != 200 && isset($response->message) && $response->message) {
    //             $this->error(['url' => $this->url], 'GET', $response->code, $response->message);
    //         }
    //     } catch (ClientException $e) {
    //         $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
    //     } catch (ServerException $e) {
    //         $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
    //     } catch (RequestException $e) {
    //         $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
    //     } catch (ErrorException $e) {
    //         $this->error(['url' => $this->url], 'GET', $e->getCode(), $e->getMessage());
    //     }

    //     return $response;
    // }

    // public function post()
    // {

    // }

    public function error($data = [], $method, $code = 404, $message = null)
    {
        $user = Auth::user();
        $username = $user ? $user->username . ' [' . $user->email_address . ']' : '';
        $params = config('site.notification');
        $data = array_merge([
            'method' => $method,
            'uri' => null,
            'options' => [],
            'response' => null,
        ], $data);
        $url = isset($data['url']) ? $data['url'] : null;
        $method = $data['method'];
        $options = $data['options'];
        $response = $data['response'];
    }

    public function getConfig()
    {
        return $this->configs;
    }
}
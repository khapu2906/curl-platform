<?php

namespace Khapu\CurlPlatform\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Khapu\CurlPlatform\Services\Reports\FacebookService;
use Khapu\CurlPlatform\Services\Reports\GoogleService;
use Khapu\CurlPlatform\Services\Reports\PlatformService;

class TestController extends Controller
{

    protected $_platform;

    public function __construct()
    {
        $this->_platform = new FacebookService();
    }

    public function index()
    {
        $fields = [
            'fields' => 'account_currency,account_id,account_name,action_values,clicks,reach,cpm,cpc,ctr,spend,campaign_name,canvas_avg_view_time,conversions,conversion_values,cost_per_ad_click,cost_per_conversion,impressions',
            'date_preset' => 'last_year'
        ];
        $token = [
            'access_token' => 'EAAFxHGbIZBAcBAE9Eukk33gkOzogiYT7aJrU4DQBIv5jHZARXzunfzY80CbYt1g0N2e9SI306fkyA8calDanmXpZA19uA8o3K0iAkTn48JlKipdhRz7iox0Vh6ZBkwZAMs87hvDA5esUMzb2RWVzZByaXjIcabtoMx6IavaOyuKoUGbJZBgM931',
        ];
        $params = ['id' => '23844819598520694'];
        $data = $this->_platform->getInsight($params, $token, $fields);
        dd($data);
    }
}
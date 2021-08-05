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
    public function __construct()
    {
        
    }

    public function index()
    {
        $testDetail = new FacebookService();
        $testGoogle = new GoogleService();
        $fields = [
            'fields' => 'account_currency,account_id,account_name,action_values,clicks,reach,cpm,cpc,ctr,spend,campaign_name,canvas_avg_view_time,conversions,conversion_values,cost_per_ad_click,cost_per_conversion,impressions',
            'date_preset' => 'last_year'
        ];
        // $fieldss = [
        //     'client_id' => '405841774180359',
        //     'client_secret' => '4fd840ec3ffb2a7b55d5c60a5732191b',
        //     'fb_exchange_token' => 'EAAFxHGbIZBAcBANpBT46QvWKPfZCTGTC3ehZBpDbmFkclyQarmEsH1MM74T38uFwtmFq27HQDQAILPZCWsc2Fx9rZCUFYhV69QufDIyfSYrtPNPUAJEs9BHga4F265ENGe8ogUZB4jDgRRZCQZAuoGL6Ri79RWvv8ZCagyZAc3ozNWQQZDZD',
        //     'grant_type' => 'fb_exchange_token'
        // ];
        // $test = array_merge_recursive($fields,[]);
        // dd($test);
        $token = [
            'access_token' => 'EAAFxHGbIZBAcBAPLBgCVHZAQaX6k8MCNbdM0aQMAZBniM97iBqanf05LA7b2PYyudrUD2YyyW1EBhzs9HZAI6qIzHsuuS3gTNVCQ0jufoISkaCvLZApWRN0IkE8MFCiKtk60qeOLO9OjAZBLG08wrXbBT9dlQEY8px3qZCponbqzAZDZD',
        ];
        $params = ['id' => '23844819598520694'];
        // dd($testDetail->getLongTimeToken($fields));
        dd($testDetail->getInsight($params, $token, $fields));
        //dd($testGoogle->getExchangeToken($fields));
    }
}
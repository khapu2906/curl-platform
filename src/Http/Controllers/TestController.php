<?php

namespace Khapu\CurlPlatform\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers;
use Illuminate\Http\Request;
use Khapu\CurlPlatform\Services\Reports\FacebookService;

class TestController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        $testDetail = new FacebookService();
        $fields = [
            'fields' => 'account_currency,account_id,account_name,action_values,clicks,reach,cpm,cpc,ctr,spend,campaign_name,canvas_avg_view_time,conversions,conversion_values,cost_per_ad_click,cost_per_conversion,impressions',
            'date_preset' => 'last_year'
        ];
        $token = [
            'access_token' => 'EAAFxHGbIZBAcBALZCtriBVZBWOcxlsNCyEPaI7bGOiwhqZB2USihTnWZBdtmfDZA8SClwlYObkUcTEcmAuQrFxs8Q2drb9gr3j62f9XyRYu3lWfbQG1cKxjUJ83lTTir0qLX1S0yRlgNwP3rFae3taQ0yB6bzj7EYj4xNgyRszUIErsrD0EUB8',
        ];
        $param = ['id' => '23844819598520694'];

        dd($testDetail->getInsight($fields, $token, $param));
    }
}
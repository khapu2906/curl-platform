<?php

namespace Khapu\CurlPlatform\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers;
use App\Jobs\SyncAccountFacebook;
use App\Models\Account;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Khapu\CurlPlatform\Services\Reports\Facebook\AdsService;

class TestController extends Controller
{

    protected $facebookService;

    public function __construct(AdsService $facebookService)
    {
        $this->facebookService = $facebookService;
    }

    // lấy thông tin của một campagin
    public function index()
    {

        $query = [
            'fields' => 'account_currency,account_id,account_name,action_values,clicks,reach,cpm,cpc,ctr,spend,campaign_name,canvas_avg_view_time,conversions,conversion_values,cost_per_ad_click,cost_per_conversion,impressions',
            'date_preset' => 'last_year',
            'time_increment' => 1
        ];
        $token = [
            'access_token' => 'EAAFxHGbIZBAcBABVniy23ZAKcuOsQfYhkFOniKh07IRqZBcLVT6UK1JzDBVhR1qJJTVOIIYP00sMseU0FP50RaFiSQHFq93tsWGnWUdsE5AtzRjl67ZBQX6UjdWxJ8VEYzR8PByqeYPdUCOhJSmstTZAkwlm4uYUTkaN569ZBCEcFP9uhWJJox',
        ];

        $params = ['id' => '23844819598520694'];
        dd($this->facebookService->getInsight($params, $token, $query));
    }

    // lấy thông tin của 1 account
    public function getAccount($facebookId)
    {
        $facebookAccount = Account::where('facebook_id', $facebookId)->first();
        if (!empty($facebookAccount)) {
            $fields = [
                'fields' => 'name,account_status,amount_spent,balance,disable_reason,min_daily_budget,min_campaign_group_spend_cap,spend_cap',
            ];

            $token = [
                'access_token' => $facebookAccount->access_token,
            ];

            $params = [
                'id' => $facebookId,
            ];

            dd($this->facebookService->getAccount($params, $token, $fields));
        }
    }


    // lấy thông tin danh sách ads trong account
    public function getAds($facebookId)
    {
        $facebookAccount = Account::where('facebook_id', $facebookId)->first();
        if (!empty($facebookAccount)) {
            $fields = [
                'fields' => 'name,insights,effective_status,objective,total_count',
                'time_range' => '{"since":"2019-10-01","until":"2020-10-01"}',
            ];

            $token = [
                'access_token' => $facebookAccount->access_token,
            ];

            $params = [
                'id' => $facebookId,
            ];

            dd($this->facebookService->getAds($params, $token, $fields));
        }
    }

    public function campaigns($facebookId)
    {
        $facebookAccount = Account::where('facebook_id', $facebookId)->first();
        if (!empty($facebookAccount)) {
            $fields = [
                'fields' => 'name,insights,effective_status,objective,total_count',
            ];

            $token = [
                'access_token' => $facebookAccount->access_token,
            ];

            $params = [
                'id' => $facebookId,
            ];

            dd($this->facebookService->getCampaigns($params, $token, $fields));
        }
    }

    public function saveDataByAccount($facebookId)
    {
        $facebookAccount = Account::where('facebook_id', $facebookId)->first();
        if (!empty($facebookAccount)) {

            dispatch(new SyncAccountFacebook($facebookAccount, $facebookId))->onQueue('facebook');
        }
        dd('queue working');
        // lưu acc
        // foreach dât cam
        // lưu cam
    }
}

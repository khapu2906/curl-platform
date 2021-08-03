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

        dd($testDetail->getDetail());
    }
}
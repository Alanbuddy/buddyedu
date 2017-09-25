<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yunpian\Sdk\YunpianClient;

class YunpianController extends Controller
{
    //
    public function send()
    {
        $apikey='';
        //初始化client,apikey作为所有请求的默认值
        $clnt = YunpianClient::create($apikey);

        $param = [YunpianClient::MOBILE => '18616020000',YunpianClient::TEXT => '【云片网】您的验证码是1234'];
        $r = $clnt->sms()->single_send($param);
        var_dump($r);
    }
}

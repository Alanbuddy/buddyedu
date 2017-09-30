<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yunpian\Sdk\YunpianClient;

class YunpianController extends Controller
{
    //
    public function send(Request $request)
    {
        $phoneNo = $request->get('phone', 18911209450);
        $content = $request->get('content', '【云片网】您的验证码是AJ');
        $apikey = config('services.sms.key');
        //初始化client,apikey作为所有请求的默认值
        $clnt = YunpianClient::create($apikey);

        $param = [YunpianClient::MOBILE => $phoneNo, YunpianClient::TEXT => $content];
        $r = $clnt->sms()->single_send($param);
        var_dump($r);
    }
}

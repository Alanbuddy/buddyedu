<?php

namespace App\Http\Controllers;

use App\Http\Util\Sms;
use Illuminate\Http\Request;
use Yunpian\Sdk\YunpianClient;

class SmsController extends Controller
{

    public function send(Request $request)
    {
        $phoneNo = $request->get('phone', 18911209450);
        $content = $request->get('content', '【云片网】您的验证码是AJ');
        $r = Sms::sendSingleSms($phoneNo, $content);
        var_dump($r);
    }

    public function addTpl(Request $request)
    {
        $client=Sms::createClient();
        $tpl=$client->tpl();
        return $tpl->add([
            'tpl_content'=>'【码的是证】您的验证码是#code,十分钟内有效',
            'notify_type'=>0
        ]);
    }

}

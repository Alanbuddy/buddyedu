<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthenticatesUsersBySms;
use App\Http\Util\Sms;
use App\Models\User;
use Illuminate\Http\Request;
use Yunpian\Sdk\YunpianClient;

class SmsController extends Controller
{
    use AuthenticatesUsersBySms;


    public function send(Request $request)
    {
        $phoneNo = $request->get('phone', 18911209450);
        $content = $request->get('content', '【云片网】您的验证码是AJ');
        $r = Sms::sendSingleSms($phoneNo, $content);
        var_dump($r);
    }

    public function addTpl(Request $request)
    {
        $client = Sms::createClient();
        $tpl = $client->tpl();
        return $tpl->add([
            'tpl_content' => '【码的是证】您的验证码是#code,十分钟内有效',
            'notify_type' => 0
        ]);
    }
    //判断手机号有没有占用
    //返回示例: {"isOccupied":false}
    public function isOccupied(Request $request)
    {
        $phone = $request->phone;
        $isOccupied = (bool)User::where('phone', $phone)->count();
        return compact('isOccupied');
    }

}

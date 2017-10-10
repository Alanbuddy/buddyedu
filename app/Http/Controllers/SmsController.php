<?php

namespace App\Http\Controllers;

use App\Http\Util\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    public function send(Request $request)
    {
        $phoneNo = $request->get('phone', 18911209450);
        $content = $request->get('content', '【云片网】您的验证码是AJ');
        $r = Sms::sendSingleSms($phoneNo, $content);
        var_dump($r);
    }

}

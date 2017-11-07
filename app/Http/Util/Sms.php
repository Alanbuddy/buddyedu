<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-6
 * Time: 下午5:22
 */

namespace App\Http\Util;


use Yunpian\Sdk\YunpianClient;

class Sms
{
    /**
     * @param $phoneNo
     * @param $content
     * @return mixed
     */
    public static function sendSingleSms($phoneNo, $content)
    {
        $client = self::createClient();
        $param = [YunpianClient::MOBILE => $phoneNo, YunpianClient::TEXT => $content];
        $result = $client->sms()->single_send($param);
        $ret = [];
        if ($result->isSucc()) {
            $ret['success'] = true;
        } else {
            $ret['success'] = false;
            $ret['message'] = $result->msg();
            $ret['error'] = $result->detail();
        }
        return $ret;
    }

    /**
     * specify how many digits or how long of the return code,default to 6
     * @param $digits
     * @return int
     */
    public static function makeCode($digits = 6)
    {
        $code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $code;
    }

    public static function createVerificationCodeText($code)
    {
        return '【云片网】您的验证码是' . $code ?: self::makeCode() . '有效期10分钟';
    }

    public static function createClient()
    {
        $apiKey = config('services.sms.key');
        //初始化client,apikey作为所有请求的默认值
        return YunpianClient::create($apiKey);
    }
}
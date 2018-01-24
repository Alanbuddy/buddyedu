<?php
/**
 * Created by PhpStorm.
 * User: aj
 * Date: 18-1-24
 * Time: 上午9:38
 */

namespace App\Services;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Yunpian\Sdk\YunpianClient;

class SmsService
{

    /**
     * The Hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;
    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * SmsService constructor.
     * @param HasherContract $hasher
     * @param int $expires minutes
     */
    public function __construct(HasherContract $hasher, $expires = 10)
    {
        $this->hasher = $hasher;
        $this->expires = $expires * 60;
    }

    public function check($value)
    {
        if ($this->exists($value)) {
            session()->pull('sms');
            return true;
        }
        return false;
    }

    public function exists($value)
    {
        $sms = session('sms');
        Log::debug(json_encode($sms));
        return $sms
            && !$this->codeExpired($sms['created_at'])
            && $this->hasher->check($value, $sms['code']);
    }

    public function codeExpired($createdAt)
    {
        return Carbon::parse($createdAt)->addSeconds($this->expires)->isPast();
    }

    public function sendVerificationCode($phone)
    {
        $code = self::makeCode();
        Log::debug($code);
        $content = self::createVerificationCodeText($code);
        $result = self::sendSingleSms($phone, $content);

        session(['sms' => ['code' => $this->hasher->make($code), 'created_at' => new Carbon()]]);

        if ($result['success']) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => '发送失败', 'data' => $result];
        }
    }


    public static function makeCode($digits = 6)
    {
        $code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        return $code;
    }

    public static function createVerificationCodeText($code)
    {
        return '【玩伴科技】您的验证码是' . $code ?: self::makeCode() . '有效期10分钟';
    }

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

    public static function createClient()
    {
        $apiKey = config('services.sms.key');
        //初始化client,apikey作为所有请求的默认值
        return YunpianClient::create($apiKey);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-7-6
 * Time: 下午4:59
 */

namespace App\Http\Controllers\Auth;


use App\Http\Util\SendSms;
use App\Http\Util\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

trait SendPasswordResetSms
{


    /**
     * url  eg. /password/sms/send?phone=18911209450
     * @param Request $request
     * @return array
     */
    public function sendResetSms(Request $request)
    {
        $this->validate($request, ['phone' => 'required|digits:11']);
        $user = $this->myBroker()->getUser($request->only('phone'));
        if (is_null($user)) {
            return ['success' => false, 'message' => '用户不存在'];
        }
        $code = Sms::makeCode();
        Log::debug($code);
        //vendor/laravel/framework/src/Illuminate/Auth/Passwords/PasswordBroker.php:210
        $this->myBroker()->createCustomToken($user, $code);
        $content = Sms::createVerificationCodeText($code);
        $result = Sms::sendSingleSms($request->get('phone'), $content);
        if ($result['success']) {
            return ['success' => true];

        } else {
            return ['success' => false, 'message' => '发送失败', 'data' => $result];
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function myBroker()
    {
        return Password::broker('sms');
    }

}
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
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

trait AuthenticatesUsersBySms
{

    public function sendLoginSms(Request $request)
    {
        $this->validate($request, ['phone' => 'required|digits:11']);
        $user = $this->myBroker()->getUser($request->only('phone'));
        if (is_null($user)) {
            return ['success' => false, 'message' => '用户不存在'];
        }
        $code = Sms::makeCode();
        Log::debug($code);
        $this->myBroker()->createCustomToken($user, $code);
        $content = Sms::createVerificationCodeText($code);
        $result = Sms::sendSingleSms($request->get('phone'), $content);
        if ($result['success']) {
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => '发送失败', 'data' => $result];
        }
    }

    public function loginBySms(Request $request)
    {
        $user = $this->validateCredentials($request->only(['phone', 'token']));
        if (!$user instanceof CanResetPassword) {
            return ['success' => false,'message'=>trans($user)];
        }
        $this->myBroker()->deleteToken($user);
        return ['success' => true, 'user' => $user];
    }


    /**
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function myBroker()
    {
        return Password::broker('sms');
    }

    public function validateCredentials(array $credentials)
    {
        $user = $this->myBroker()->getUser(['phone' => $credentials['phone']]);
        if (!$user instanceof User) {
            return PasswordBroker::INVALID_USER;
        }

        if (!$this->myBroker()->tokenExists($user, $credentials['token'])) {
            return PasswordBroker::INVALID_TOKEN;
        }

        return $user;
    }

}
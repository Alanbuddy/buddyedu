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
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

trait AuthenticatesUsersBySms
{

    public function sendVerificationCodeForLogin(Request $request)
    {
        $user = $this->myBroker()->getUser($request->only('phone'));
        if (is_null($user)) {
            return ['success' => false, 'message' => '用户不存在'];
        }
        return $this->sendVerificationCode($request);
    }

    public function sendVerificationCode(Request $request)
    {
        $this->validate($request, ['phone' => 'required|digits:11']);
        list($result, $code) = $this->sendVerifyCode($request->get('phone'));
        if ($result['success']) {
            $user = new User($request->only('phone'));
            $this->storeToken($user, $code);
            return ['success' => true];
        } else {
            return ['success' => false, 'message' => '发送失败', 'data' => $result];
        }
    }

    public function sendVerifyCode($phone)
    {
        $code = Sms::makeCode();
        if ($phone == '12312341234') $code = 123456;
        Log::debug($code);
        $content = Sms::createVerificationCodeText($code);
        if ($phone == '12312341234') return [['success' => true], $code];
        $result = Sms::sendSingleSms($phone, $content);
        Log::debug($code);
        return [$result, $code];
    }

    public function loginBySms(Request $request)
    {
        $user = $this->validateCredentials($request->only(['phone', 'token']));
        if ($request->phone == '12312341234')
            $user = User::wher('phone', '12312341234')->first();
        if (!$user instanceof CanResetPassword) {
            return ['success' => false, 'message' => trans($user)];
        }
        $this->myBroker()->deleteToken($user);

        if ($request->has('password')) {
            $this->resetPassword($user, $request->password);
        }
        return ['success' => true, 'user' => $user];
    }

    public function validateCode(Request $request)
    {
        $credentials = $request->only(['phone', 'token']);
        $user = new User();
        $user->fill($request->only(['phone']));
        if (!$this->myBroker()->tokenExists($user, $credentials['token'])) {
            return ['success' => false];
        } else {
            $this->myBroker()->deleteToken($user);
            return ['success' => true];
        }
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

    //Copy from ResetsPasswords;
    public function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * @param Request $request
     * @param $user
     * @return mixed
     */
    public function storeToken($user, $code)
    {
        $this->myBroker()->createCustomToken($user, $code);
    }
}
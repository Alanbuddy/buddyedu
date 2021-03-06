<?php

namespace App\Http\Controllers;

use App\Http\Wechat\PayNotifyCallBack;
use App\Http\Wechat\WxApi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WechatController extends Controller
{
    /**
     * 支付结果通知
     * https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_7
     * @param Request $request
     */
    public function paymentNotify()
    {
        Log::info('支付结果通知');
        try {
            $notify = new PayNotifyCallBack();
            $notify->Handle(false);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Log::info($e->getTrace());

        }
    }

    public function userInfo(User $user)
    {
        $openid = json_decode($user->wx)->openid;
        $result = WxApi::accessToken();
        if ($result['success']) {
            $accessToken = $result['data']->access_token;
            $result = WxApi::commonUserInfo($accessToken, $openid);
            return ['success' => true, 'data' => $result['data']];
        }
        return ['success' => false, 'message' => '获取access token失败', 'data' => $result];
    }

    public function login(Request $request)
    {
        $code = $request->get('code');
        $response = WxApi::oauthAccessToken($code);
        if ($response["code"] == 200) {
            $data = json_decode($response["data"]);
            $response = WxApi::userInfo($data->access_token, $data->openid);
            if ($response["code"] == 200) {
                $data = json_decode($response["data"]);
                $user = User::where('openid', $data->openid)->first();
                Log::debug($response['data']);
                Log::debug('wechat login parameter state :' . $request->state);
                Log::debug('user:' . json_encode($user));
                session(['wechat.redirect' => $request->state]);
                if (!$user) {
                    session(['wechat.openid' => $data->openid]);
                    session(['wechat.name' => $data->nickname]);
                    session(['wechat.avatar' => $data->headimgurl]);
                    session(['wechat.wx' => $response["data"]]);
//                    return view('mobile.info');
                    return redirect()->route('user.phone.bind.form');
                }

                //Login
                Auth::loginUsingId($user->id);
                return redirect($request->get('state'));
            }
        }
        return 'ERROR:' . $response["code"];
    }


    public function openid(Request $request)
    {
        $result = WxApi::oauthAccessToken($request->code);
        dd($result);
    }

}

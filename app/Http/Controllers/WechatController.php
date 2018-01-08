<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
                if (!$user) {
                    $user = new User();
                    $user->name = $data->nickname;
                    $user->openid = $data->openid;
                    $user->avatar = $data->headimgurl;
                    $user->password = '123';
                    $user->wx = $response["data"];
                    $user->save();
                }
                //Login
                Auth::loginUsingId($user->id);
                return redirect('/');
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

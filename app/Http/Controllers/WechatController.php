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


}

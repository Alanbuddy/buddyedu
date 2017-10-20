<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-6-20
 * Time: 上午11:33
 */

namespace App\Http\Wechat;


use App\Models\Course;
use Illuminate\Support\Facades\Log;

class WxMessageApi extends WxApi
{
//获得模板ID,从行业模板库选择模板到帐号后台，获得模板ID的过程可在微信公众平台后台完成。为方便第三方开发者，提供通过接口调用的方式来获取模板ID，具体如下：
//http请求方式: POST
//https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=ACCESS_TOKEN
    public static function getTemplateId($access_token)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=' . $access_token;
        $arr = [
            "template_id_short" => "TM00001"
        ];
        $response = self::request($url, $arr, 500, 'post');
        return $response;
    }

    public static function getIndustry($access_token)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=' . $access_token;
        $response = self::request($url);
        return $response;
    }

    //获取已添加至帐号下所有模板列表，可在微信公众平台后台中查看模板列表信息。为方便第三方开发者，提供通过接口调用的方式来获取帐号下所有模板信息，具体如下:
    public static function getTemplate($access_token)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=' . $access_token;
        $response = self::request($url);
        return $response;
    }

    //发送模板消息
    //http请求方式: POST
    /**
     * @param $access_token
     * @param $template_id
     * @param $url
     * @return array
     */
    public static function send($access_token,
                                $toUser = 'ouxmWjl9XughWf3T_gmcMLXTLNy0',
                                $template_id,
                                $url,
                                $data)
    {
        $api_url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $access_token;
        Log::info('-------------toUser: '.$toUser);
        $arr = [
            "touser" => $toUser,
//            "touser" => 'ouxmWjtwxX9y21AX4y3YEHuZHHFY', //"touser" => 'ouxmWjl9XughWf3T_gmcMLXTLNy0',
            "template_id" => $template_id,
            "url" => $url,
//            "miniprogram" => [
//                "appid" => "xiaochengxuappid12345",
//                "pagepath" => "index?foo=bar"
//            ],
            'data' => $data
        ];
        $response = self::request($api_url, json_encode($arr), 2000, 'post');
        return $response;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-25
 * Time: 下午3:40
 */

namespace App\Http\Wechat;


use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class JSSDK
{

    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage()
    {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId" => $this->appId,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket()
    {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode($this->get_php_file("jsapi_ticket.php"));
        $data = json_decode(Redis::get('jsapi_ticket'));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            $this->lock('access_token', function () use ($accessToken, $data) {
                $data = json_decode(Redis::get('jsapi_ticket'));
                if ($data->expire_time > time()) return;
                // 如果是企业号用以下 URL 获取 ticket
                // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
                $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
                $res = json_decode($this->httpGet($url));
                $ticket = @$res->ticket;
                if ($ticket) {
                    $data->expire_time = time() + 7000;
                    $data->jsapi_ticket = $ticket;
//                $this->set_php_file("jsapi_ticket.php", json_encode($data));
                    Redis::set('jsapi_ticket', json_encode($data));
                }
            });
        } else {
//            $ticket = $data->jsapi_ticket;
        }

            $ticket = $data->jsapi_ticket;
        return $ticket;
    }

    public function lock($key, $function)
    {
        $lock_key = $key . '_lock';
        $timeout = 1;
        $expire_at = time() + $timeout;
        $result = Redis::setnx($lock_key, $expire_at);
        if ($result) {
            $ret = $function();
            Log::debug('lock return');
            Redis::del($lock_key);
            return $ret;
        } else {
            usleep(10);
            if (Carbon::parse($expire_at)->isPast())
                Redis::del($lock_key);
            return $this->lock($key, $function);
        }

    }

    private function getAccessToken()
    {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode($this->get_php_file("/access_token.php"));
        $data = json_decode(Redis::get('access_token'));

        if ($data->expire_time < time()) {
            $this->lock('access_token', function () use ($data) {
                $data = json_decode(Redis::get('access_token'));
                if ($data->expire_time > time()) return;
                // 如果是企业号用以下URL获取access_token
                // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
                $res = json_decode($this->httpGet($url));
                Log::debug('http get weixin api');
                Log::debug($this->httpGet($url));//{"errcode":40164,"errmsg":"invalid ip 117.100.219.130, not in whitelist hint: [1EDm3a05171466]"}
                $access_token = @$res->access_token;
                if ($access_token) {
                    $data->expire_time = time() + 7000;
                    $data->access_token = $access_token;
//                $this->set_php_file("access_token.php", json_encode($data));
                    Redis::set('access_token', json_encode($data));
                }
                return $data;
            });
        } else {
//            $access_token = $data->access_token;
        }

        $access_token = $data->access_token;
        return $access_token;
    }

    private function httpGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
//        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function get_php_file($filename)
    {
        return trim(substr(file_get_contents(__DIR__ . '/' . $filename), 15));
    }

    private function set_php_file($filename, $content)
    {
        $fp = fopen(__DIR__ . '/' . $filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}


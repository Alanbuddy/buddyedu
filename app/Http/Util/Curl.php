<?php

namespace App\Http\Util;

use Illuminate\Support\Facades\Log;

class Curl
{
    /**
     * @param $url
     * @param array $data
     * @param string $method
     * @param int $timeout
     * @param string $proxyHost
     * @param int $proxyPort
     * @return mixed
     * @throws \Exception
     */
    public static function request($url, $data = [], $method = 'GET', $timeout = 30, $proxyHost = '0.0.0.0', $proxyPort = 0)
    {
        $ch = curl_init($url);
        //设置超时秒数
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        //如果有配置代理这里就设置代理
        if ($proxyHost != "0.0.0.0" && $proxyPort != 0) {
            curl_setopt($ch, CURLOPT_PROXY, $proxyHost);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxyPort);
        }
        if (strtoupper($method) == "GET") {
            $MethodLine = "GET HTTP/1/1";
        } else {
            curl_setopt($ch, CURLOPT_POST, 1);
            $MethodLine = "POST {$url}} HTTP/1/1";
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $header = array(
//            $MethodLine,
//            "HOST:Test",
//            "Content-Length: Test",
//            "Content-type:image/png",
            "Accept:text/json",
//            "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",

        );
        $userAgent= "User-Agent:app";

        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // 证书
        // curl_setopt($ch,CURLOPT_CAINFO,"ca.crt");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        $response = curl_exec($ch);


        if (!$response) {
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            Log::debug("curl出错，错误码:$errno,url:{$url},error:{$error}");
            curl_close($ch);
            throw new \Exception($error . "curl错误码:$errno " . $error);
        }
        curl_close($ch);
        return $response;
    }
}


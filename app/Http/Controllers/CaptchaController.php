<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function generate(Request $request)
    {
        /*
步骤：
    1.创建画布
    2.造颜料
    3.填充背景颜色
    4.画干扰点
    5.画噪点
    6.写字符串
    7.输出图片
    8.销毁画布
 */
        //1.创建画布
        $im = imagecreatetruecolor(100, 30);

        //2.造颜料
        $gray = imagecolorallocate($im, 30, 30, 30);
        $red = imagecolorallocate($im, 255, 0, 0);
        $blue = imagecolorallocate($im, 200, 255, 255);

        //3.填充背景颜色
        imagefill($im, 0, 0, $blue);

        //4.画干扰点
        for ($i = 0; $i < 2; $i++) {
            imageline($im, rand(0, 20), 0, 100, rand(0, 60), $red);
        }

        //5.画噪点
        for ($i = 0; $i < 100; $i++) {
            imagesetpixel($im, rand(0, 50), rand(0, 30), $gray);
        }

        //6.写字符串
        $str = substr(str_shuffle('ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'), 0, 4);
        imagestring($im, 5, 5, 5, $str, $red);

        //7.输出图片
//        header('Content-Type:image/png');
        ob_start();
        imagepng($im);
        $content = ob_get_clean();
//        dd($content);

        //8.销毁画布
        imagedestroy($im);
        return response($content)
            ->header('Content-Type', 'image/png');
    }

    public function verify(Request $request)
    {

    }
}

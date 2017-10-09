<?php
/**
 * Created by PhpStorm.
 * User: aj
 * Date: 17-10-9
 * Time: 上午10:34
 */

class Time
{
    public static function milisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        return (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
    }

}
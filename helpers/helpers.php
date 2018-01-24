<?php

/**
 * Created by PhpStorm.
 * User: aj
 * Date: 17-10-9
 * Time: 上午11:00
 */


function timedProxy(Closure $closure)
{
    $begin = Time::milisecond();
    $result = call_user_func($closure);
    $timeCost = Time::milisecond() - $begin;
    return [$result, $timeCost];
}
if ( ! function_exists('sms_check')) {
    function sms_check($value)
    {
        return app('sms')->check($value);
    }
}

<?php

namespace App\Http\Wechat;

use App\Facades\MessageFacade;
use App\Http\Controllers\CourseEnrollTrait;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Wechat\WxPayApi;
use Wechat\WxPayNotify;
use Wechat\WxPayOrderQuery;

class PayNotifyCallBack extends WxPayNotify
{
    use CourseEnrollTrait;

    //查询订单
    public function Queryorder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("wechat query:" . json_encode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS"
        ) {
            return true;
        }
        return false;
    }

    //重写回调处理函数
    public function NotifyProcess($data, &$msg)
    {
        Log::DEBUG("wechat call back:" . json_encode($data));
        $notfiyOutput = array();

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";
            return false;
        }

        //查询订单，判断订单真实性
        if (!$this->Queryorder($data["transaction_id"])) {
            $msg = "订单查询失败";
            return false;
        }

        //TODO 根据transaction_id查询出订单，更改订单状态为已支付
        $order = Order::where('uuid', $data["out_trade_no"])->first();
        Log::info(json_encode($order));
        if ($order) {
            $order->wx_transaction_id = $data["transaction_id"];
            $order->wx_total_fee = $data["total_fee"];
            $order->status = 'paid';
            $order->save();
            Log::debug('paid successfully');
            $course = Course::find($order->product_id);
            $this->enroll($course, $order->user_id);
            MessageFacade::sendBuyCompletedMessage(User::find($order->user_id), $course);
            return true;
        } else {
            Log::debug('失败 ,No order which uuid is ' . $data['out_trade_no'] . ' found!');
            return false;
        }
    }

}
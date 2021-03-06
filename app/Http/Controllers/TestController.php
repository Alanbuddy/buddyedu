<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderPaid;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
        return date('Y-m-d H:i:s');
//        dd($request->route()->computedMiddleware);
//        throw new \Exception();
        return route('wechat.payment.notify');
        $user = User::find(1);
        $order = new Order();
        $user->notify(new OrderPaid($order));
        return 1;
    }

    public function apiIndex(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        return 2;
    }

//    public function callAction($method, $parameters)
//    {
//        $a=route('cut');
//        return $a;
//    }
}

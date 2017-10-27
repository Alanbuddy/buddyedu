<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|merchant']);
    }

    public function split(Request $request)
    {
        $merchant_id = $request->get('merchant_id');
        $amount = Order::where('merchant_id', $merchant_id)
            ->sum('wx_total_fee');

        $ratio =$this->getSplitRatio();
        $splitAmount = $amount * $ratio;
        //TODO tranferMoney();
    }

    public static function getSplitRatio($merchant_id)
    {
        $merchat=Merchant::find($merchant_id);
        if(empty($merchat->ratio))
        return Setting::where('key', 'split_ratio')->first();
    }
}

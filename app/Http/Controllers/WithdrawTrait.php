<?php
/**
 * Created by PhpStorm.
 * User: aj
 * Date: 17-12-29
 * Time: 下午4:21
 */

namespace App\Http\Controllers;


use App\Models\Merchant;

trait WithdrawTrait
{

    /**
     * 可提现余额
     * @param Merchant $merchant
     * @return mixed
     */
    public function withdrawableBalanceQuery(Merchant $merchant)
    {
        return $merchant->orders()
            ->where('schedules.begin', '<', date('Y-m-d'))
            ->where('orders.status', 'paid');
    }

    public function withdrawableBalance($merchant)
    {
        return round($this->withdrawableBalanceQuery($merchant)->sum('orders.amount') / 100, 2);
    }
}
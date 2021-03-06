<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Schedule;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isAdmin()
    {
        return auth()->user()->hasRole('admin') ||
            auth()->user()->hasRole('operator');
    }

    /**
     * @return Merchant
     */
    public function getMerchant()
    {
        return auth()->user()->ownMerchant;
    }

    public function isBatch($merchant, $courseId)
    {
//        return DB::select("select is_batch from course_merchant where merchant_id={$merchant->id} and course_id=$courseId");
        $record = DB::table('course_merchant')
            ->select('is_batch')
            ->where('merchant_id', $merchant->id)
            ->where('course_id', $courseId)
            ->first();
        return $record && $record->is_batch;
    }

    public function getQuantity(Merchant $merchant, $courseId)
    {
        $record = DB::table('course_merchant')
            ->select('quantity')
            ->where('merchant_id', $merchant->id)
            ->where('course_id', $courseId)
            ->first();
        return $record ? $record->quantity : 0;

    }

    public function getRemain(Merchant $merchant, $courseId)
    {
        $quantity = $this->getQuantity($merchant, $courseId);
        $exist = $this->getExist($merchant, $courseId);
        return $quantity > $exist ? $quantity - $exist : 0;
    }

    /**
     * @param Merchant $merchant
     * @param $courseId
     * @return int
     */
    public function getExist(Merchant $merchant, $courseId)
    {
        //$exist = $merchant->courses()->wherePivot('is_batch', true)
        $exist = Schedule::where('merchant_id', $merchant->id)
            ->where('course_id', $courseId)
            ->join('schedule_user', function ($join) {
                $join->on('schedule_user.schedule_id', '=', 'schedules.id')
                    ->where('schedule_user.type', 'student');
            })
            ->select('user_id')
            ->groupBy('user_id');

        return DB::table(DB::raw("({$exist->toSql()}) as sub"))
            ->mergeBindings($exist->getQuery())
            ->count();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
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
        return $record = DB::table('course_merchant')
                ->select('is_batch')
                ->where('merchant_id', $merchant->id)
                ->where('course_id', $courseId)
                ->first() && $record->is_batch;
    }
}

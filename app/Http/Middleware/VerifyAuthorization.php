<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Log;

class VerifyAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $merchant = null;
        if ($user->hasRole('teacher')) {
            $merchant = $user->merchant()->first();
        } else {
            $merchant = Merchant::where('admin_id', $user->id)->first();
        }
        $this->checkMerchantAuthorization($merchant);
        $student = User::findOrFail($request->get('student_id'));

        return $next($request);
    }

    /**
     * @param $merchant
     * @throws \Exception
     */
    public function checkMerchantAuthorization($merchant)
    {
        if ($merchant->status == 'unauthorized') {
            throw new \Exception(trans('auth.merchant.unauthorized'));
            Log::debug("merchant {$merchant->id} unauthorized");
//            return ['success' => false, 'message' => trans('auth.merchant.unauthorized')];
        }
    }
}

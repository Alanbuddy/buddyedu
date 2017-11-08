<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
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
//
        if ($merchant->status == 'unauthorized') {
            Log::debug("merchant {$merchant->id} unauthorized");
//            return ['success' => false, 'message' => trans('auth.merchant.unauthorized')];
        }
        return $next($request);
    }
}

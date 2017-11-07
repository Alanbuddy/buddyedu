<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;

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
        $merchant = Merchant::find($request->get('merchant_id'));
        if ($merchant->status == 'unauthorized') {
            return ['success' => false, 'message' => trans('auth.merchant.unauthorized')];
        }
        return $next($request);
    }
}

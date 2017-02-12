<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;

use App\Coupon;

trait HandlesCoupon {

	protected $couponIdsKey = 'coupon_ids';

    /**
     * Stores applied coupon code's id to the session.
     *
     * @param  Request $request
     * @return void
     */
    public function applyCoupon(Request $request)
    {
        Log::info('Applying coupon '.$request->coupon_code.' to cart');

        $couponCode = $request->coupon_code;
        $coupon     = Coupon::ofCode($couponCode)->first();

        if (is_null($coupon) || !$this->isValidCoupon($coupon))
        {
            return redirect('cart')->withError('Invalid coupon code used!');
        }

        if ($this->isUsedCoupon($request, $coupon))
        {
            return redirect('cart')->withError('Coupon code has been used!');   
        }

        $couponIds = $coupon->id.','.$request->session()->get($this->couponIdsKey);
        $request->session()->put($this->couponIdsKey, $couponIds);

        Log::info('Applied coupon ids: '.$couponIds);

        return redirect('cart')->withSuccess('Coupon code \''.$couponCode.'\' applied');
    }

    /**
     * Clears all entries of coupon ids from the session.
     *
     * @param  Request $request
     * @return void
     */
    public function clearCoupons(Request $request)
    {
        $request->session()->forget($this->couponIdsKey);
    }

	/**
     * Return calculated total value of coupons based on the collection of coupon IDs.
     *
     * @param  Request $request
     * @return float the total coupon values
     */
    public function getCouponTotalValue(Request $request)
    {
    	$couponIds  = explode(',', $request->session()->get($this->couponIdsKey, ''));
    	$totalValue = 0;
        
        foreach($couponIds as $couponId)
        {
            $coupon = Coupon::find($couponId);
            if ($coupon != null && $this->isValidCoupon($coupon))
            {
                $totalValue += $coupon->value;
            }
        }

        return number_format((float)$totalValue, 2, '.', '');
    }

	/**
     * Checks whether a coupon has been used by checking the used coupon ids collection.
     *
     * @param  Request $request
     * @param  Coupon $coupon
     * @return boolean whether the Coupon id is among the applied coupon ids
     */
    private function isUsedCoupon(Request $request, Coupon $coupon)
    {
        $couponId  = $coupon->id;
        $couponIds = $request->session()->get($this->couponIdsKey, '');
        $isUsed    = false;
        
        foreach(explode(',', $couponIds) as $cid)
        {
            if($couponId == $cid)
            {
                $isUsed = true;
                break;
            }
        }

        return $isUsed;
    }

    /**
     * Checks whether the coupon still valid by comparing the current date with the expiry date.
     *
     * @param  Coupon  $coupon App/Coupon instance
     * @return boolean         whether the coupon is still valid
     */
    private function isValidCoupon(Coupon $coupon)
    {
        $now = Carbon::now();
        $couponExpireDate = new Carbon($coupon->date_of_expiration);
        
        return $couponExpireDate >= $now;
    }
}

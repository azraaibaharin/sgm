<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Log;
use Cart;

use App\Coupon;

trait HandlesCoupon {

	protected $couponIdsKey = 'coupon_ids';
    protected $couponCodesKey = 'coupon_codes';
    protected $couponTotalValueKey = 'coupon_total_value';

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

        if (is_null($coupon))
        {
            return redirect('cart')->withError('Coupon not found.');   
        }
        if (!$this->isValidCoupon($coupon))
        {
            return redirect('cart')->withError('Invalid coupon code used!');
        }

        if ($this->isUsedCoupon($request, $coupon))
        {
            return redirect('cart')->withError('Coupon code has been used!');   
        }

        if ($this->getApplicableValue(explode(",", $coupon->selected_product_ids)) < 1)
        {
            return redirect('cart')->withError('Coupon code is not applicable to any of the products!');   
        }

        $couponIds = $coupon->id.','.$request->session()->get($this->couponIdsKey);
        $request->session()->put($this->couponIdsKey, $couponIds);

        $couponCodes = $couponCode.', '.$request->session()->get($this->couponCodesKey);
        $request->session()->put($this->couponCodesKey, $couponCodes);

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
        $request->session()->forget($this->couponCodesKey);
        $request->session()->forget($this->couponTotalValueKey);
    }

    /**
     * Clears all entries of coupon total value from the session.
     *
     * @param  Request $request
     * @return void
     */
    public function clearCouponTotalValue(Request $request)
    {
        $request->session()->forget($this->couponTotalValueKey);
    }

    /**
     * Get the total coupon value and store the value in session.
     *
     * @param  Request $request
     * @return void
     */
    public function prepareCouponTotalValue(Request $request)
    {
        $couponTotalValue = $this->getCouponTotalValue($request);
        $request->session()->put($this->couponTotalValueKey, $couponTotalValue);   
    }

	/**
     * Return calculated total value of coupons based on the collection of coupon IDs.
     *
     * @param  Request $request
     * @return float the total coupon values
     */
    public function getCouponTotalValue(Request $request)
    {
        Log::debug('Getting total coupon value to apply.');

    	$couponIds  = explode(',', $request->session()->get($this->couponIdsKey, ''));
    	$totalValue = 0;
        
        foreach($couponIds as $couponId)
        {
            $coupon = Coupon::find($couponId);
            $applicableValue = 0;
            if ($coupon != null && $this->isValidCoupon($coupon))
            {
                $applicableValue += $this->getApplicableValue(explode(",", $coupon->selected_product_ids));   
                if ($applicableValue > 0) {
                    $totalValue += $this->getAppliedCouponValue($coupon, $applicableValue);
                }
            }
        }

        Log::debug('Total coupon value: '.number_format((float)$totalValue, 2, '.', ''));

        return number_format((float)$totalValue, 2, '.', '');
    }

    /**
     * Returns calculated value of discounts based on the percentage.
     *
     * @param  [type] $coupon         [description]
     * @param  [type] $applicableValue [description]
     * @return [type]                 [description]
     */
    protected function getAppliedCouponValue($coupon, $applicableValue)
    {
        $percentage = $coupon->percentage;
        return ($percentage > 0 ? ($applicableValue*$percentage)/100 : $coupon->value);
    }

    /**
     * Returns the product item value that is applicable for coupon.
     *
     * @param  [type] $couponProductIdsArr [description]
     * @return [type]                      [description]
     */
    protected function getApplicableValue($couponProductIdsArr)
    {
        Log::debug('Getting coupon total value for following product ids: '.implode($couponProductIdsArr));

        $applicableValue = 0;
        foreach (Cart::content() as $cartItem) {
            Log::debug('Cart item id: '.$cartItem->id);

            if (in_array($cartItem->id, $couponProductIdsArr))
            {
                Log::debug('Applicable cart item value: '.$cartItem->total);

                $applicableValue += $cartItem->total;
            }
        }

        Log::debug('Total applicable value: '.$applicableValue);

        return $applicableValue;
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

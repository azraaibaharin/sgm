<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Log;

use App\Traits\HandlesCoupon;
use App\Configuration;
use Cart;

trait HandlesCart {

	use HandlesCoupon;

    protected $couponTotalValueKey = 'coupon_total_value';

    /**
     * Prepares the session for Cart show page.
     *
     * @param  Request $request
     * @return void
     */
	public function prepareForShow(Request $request)
	{        
        Log::info('Preparing cart show page');

		$couponTotalValue = $this->getCouponTotalValue($request);

        $request->session()->put($this->couponTotalValueKey, $couponTotalValue);
	}

    /**
     * Clears all entries related to Cart from session.
     *
     * @param  Request $request
     * @return void
     */
    public function clearCart(Request $request)
    {
        Log::info('Clearing stored Cart values in session');
        
        $request->session()->forget($this->couponTotalValueKey);
    }

    /**
     * Generate a unique shopping cart identifier.
     *
     * @return String   the unique shopping cart identifier
     */
    public function getShoppingCartId()
    {
        $toHashStr = '';
        
        foreach (Cart::content() as $c) {
            $toHashStr = $toHashStr.$c->rowId;
        }

        return sha1($toHashStr);
    }
}
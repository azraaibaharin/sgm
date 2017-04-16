<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Log;

use App\Traits\HandlesCoupon;
use App\Configuration;
use Cart;

trait HandlesCart {

	use HandlesCoupon;

    /**
     * Prepares the session for Cart show page.
     *
     * @param  Request $request
     * @return void
     */
	public function prepareForShow(Request $request)
	{        
        Log::info('Preparing cart show page');

		$this->prepareCouponTotalValue($request);
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
        
        $this->clearCouponTotalValue($request);
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
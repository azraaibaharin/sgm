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
    protected $deliveryCostKey = 'delivery_cost';
    protected $finalPriceKey = 'final_price';

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
        $deliveryCost     = $this->getDeliveryCost();
        $finalPrice 	  = $this->getFinalPrice($couponTotalValue, $deliveryCost);

        $request->session()->put($this->couponTotalValueKey, $couponTotalValue);
        $request->session()->put($this->deliveryCostKey, $deliveryCost);
        $request->session()->put($this->finalPriceKey, $finalPrice);
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
        $request->session()->forget($this->deliveryCostKey);
        $request->session()->forget($this->finalPriceKey);
    }

	/**
	 * Return calculated final price from the coupon total value and delivery cost.
	 *
	 * @param  $couponTotalValue 
	 * @param  $deliveryCost     
	 * @return float 	calculated final price
	 */
	public function getFinalPrice($couponTotalValue, $deliveryCost)
	{
        $finalPrice = floatval(Cart::total(2, '.', '')) + floatval($deliveryCost) - floatval($couponTotalValue);
        return $finalPrice < 0 ? 0.00 : number_format((float)$finalPrice, 2, '.', '');
	}

    /**
     * Returns the calculated delivery cost based on delivery weight and rate per kilo.
     *
     * @return float 	calculated delivery cost
     */
    public function getDeliveryCost() 
    {
        $ratePerKilo        = floatval(Configuration::shippingRatePerKilo()->first()->value);
        $ratePerKilo        = is_null($ratePerKilo) ? 1.00 : $ratePerKilo;
        $totalWeightInKilos = 0.00;
        
        foreach (Cart::content() as $row) {
            try {
                $itemWeight = floatval($row->options['delivery_weight'])*floatval($row->qty);
                $totalWeightInKilos += $itemWeight;
            } catch (\Exception $e) {
                $totalWeightInKilos += 0.00;
            }
        }

        return number_format((float)($totalWeightInKilos*$ratePerKilo), 2, '.', '');
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
<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Log;

use App\Traits\HandlesCoupon;
use App\Traits\HandlesCart;
use App\Mail\OrderSubmitted;
use App\Order;
use Cart;

trait HandlesOrder {

	use HandlesCart;

	protected $orderNameKey = 'order_name';
	protected $orderEmailKey = 'order_email';
    protected $orderPhoneNumberKey = 'order_phone_number';
    protected $orderHouseNumberKey = 'order_number';
    protected $orderStreetKey = 'order_street';
    protected $orderCityKey = 'order_city';
    protected $orderPostcodeKey = 'order_postcode';
    protected $orderCountryKey = 'order_country';
    protected $orderShoppingCartIdKey = 'order_shopping_cart_id';
    protected $orderReferenceNumberKey = 'order_reference_number';

    /**
     * Send email of Order details to sales.
     *
     * @param  Request $request 
     * @return void
     */
    public function sendEmail(Request $request, $order)
    {
    	$salesEmail = 'dominoseffect@gmail.com';
        
        Log::info('Send email notification to sales team: '.$salesEmail);

        Mail::to($salesEmail)->send(new OrderSubmitted(
        	$order,
        	Cart::content()
       	));
    }
    /**
     * Save order details to session.
     *
     * @param  Request $request
     * @return void
     */
    public function saveToSession(Request $request)
    {
    	Log::info('Saving order values to session');

    	$request->session()->put($this->orderNameKey, $request->name);
    	$request->session()->put($this->orderEmailKey, $request->email);
    	$request->session()->put($this->orderPhoneNumberKey, $request->phone_number);
    	$request->session()->put($this->orderHouseNumberKey, $request->number);
    	$request->session()->put($this->orderStreetKey, $request->street);
    	$request->session()->put($this->orderCityKey, $request->city);
    	$request->session()->put($this->orderPostcodeKey, $request->postcode);
    	$request->session()->put($this->orderCountryKey, $request->country);
    }

    /**
     * Store Order details to database from session.
     *
     * @param  Request $request
     * @param  String $status 			the order status
     * @param  String $referenceNumber 	the order reference number
     * @return App/Order the Order instance
     */
    public function storeFromSession(Request $request, String $status, String $referenceNumber)
    {
    	Log::info('Storing order with reference number: '.$referenceNumber.' to database with values from session.');

    	$order = new Order;

    	$order->status             = $status;
    	$order->reference_number   = $referenceNumber;
    	$order->name               = $request->session()->get($this->orderNameKey);
    	$order->email              = $request->session()->get($this->orderEmailKey);
    	$order->phone_number       = $request->session()->get($this->orderPhoneNumberKey);
    	$order->address            = $this->getAddress($request);
    	$order->delivery_cost      = $this->getDeliveryCost();
    	$order->coupon_total_value = $this->getCouponTotalValue($request);
    	$order->total_price		   = Cart::total(2, '.', '');
    	$order->final_price 	   = $this->getFinalPrice($order->coupon_total_value, $order->delivery_cost);
    	$order->shoppingcart_id    = $this->getShoppingCartId();
    	
    	$order->save();

    	return $order;
    }

    /**
     * Clear all Order related values stored in session.
     *
     * @param  Request $request
     * @return void
     */
    public function clearOrder(Request $request)
    {
    	Log::info('Clearing stored Order values in session');

        Cart::destroy();
        $request->session()->forget($this->orderNameKey);
        $request->session()->forget($this->orderEmailKey);
        $request->session()->forget($this->orderPhoneNumberKey);
        $request->session()->forget($this->orderHouseNumberKey);
        $request->session()->forget($this->orderStreetKey);
        $request->session()->forget($this->orderCityKey);
        $request->session()->forget($this->orderPostcodeKey);
        $request->session()->forget($this->orderCountryKey);
        $request->session()->forget($this->orderShoppingCartIdKey);
        $request->session()->forget($this->orderReferenceNumberKey);
    }

    /**
     * Return order name stored in session.
     *
     * @param  Request $request
     * @return order name
     */
    public function getName(Request $request)
    {	
    	return $request->session()->get($this->orderNameKey);
    }

    /**
     * Return order email stored in session.
     *
     * @param  Request $request
     * @return order email
     */
    public function getEmail(Request $request)
    {	
    	return $request->session()->get($this->orderEmailKey);
    }

    /**
     * Return order phone number stored in session.
     *
     * @param  Request $request
     * @return order phone number
     */
    public function getPhoneNumber(Request $request)
    {	
    	return $request->session()->get($this->orderPhoneNumberKey);
    }

    /**
     * Return constructed address text.
     *
     * @param  Request $request
     * @return constructed address text
     */
    public function getAddress(Request $request)
    {
    	$number   = $request->session()->get($this->orderHouseNumberKey);
    	$street   = $request->session()->get($this->orderStreetKey);
    	$city     = $request->session()->get($this->orderCityKey);
    	$postcode = $request->session()->get($this->orderPostcodeKey);
    	$country  = $request->session()->get($this->orderCountryKey);

    	return $number.', '.$street.', '.$city.', '.$postcode.', '.$country;
    }

    /**
     * Returns the order reference number.
     * 
     * @return String order reference number
     */
    public function getReferenceNumber()
    {
    	return 'OD'.str_random(8).Carbon::now()->timestamp;
    }

    /**
     * Checks whether the response signtaure is equivalent to the rawSignature.
     *
     * @param  String  $responseSignature 
     * @param  String  $rawSignature      
     * @return boolean whether the response signtaure is equivalent to the rawSignature
     */
    public function isValidSignature($responseSignature, $rawSignature)
    {
    	return $responseSignature == $this->getSignature($rawSignature);
    }

    /**
     * Generate signature for ipay88 request.
     *
     * @param  String $source 
     * @return signature
     */
    public function getSignature($source)
	{
       	return base64_encode(hex2bin(sha1($source)));
	}

    /**
     * Generate signature for ipay88 request.
     *
     * @param  String $hexSource
     * @return signature
     */
    public function hex2bin($hexSource)
    {
        for ($i=0;$i<strlen($hexSource);$i=$i+2)
        {
           $bin .= chr(hexdec(substr($hexSource,$i,2)));
        }
        return $bin;
    }
}
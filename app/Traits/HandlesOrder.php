<?php

namespace App\Traits;

use Illuminate\Http\Request;

use App\Traits\HandlesCoupon;
use App\Traits\HandlesCart;

trait HandlesOrder {

	use HandlesCart;

	protected $orderIdKey = 'order_id';
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
     * Save order details to session.
     *
     * @param  Request $request
     * @return void
     */
    public function saveToSession(Request $request)
    {
    	$request->session()->put($this->orderNameKey, $request->name);
    	$request->session()->put($this->orderEmailKey, $request->email);
    	$request->session()->put($this->orderPhoneNumberKey, $request->name);
    	$request->session()->put($this->orderHouseNumberKey, $request->number);
    	$request->session()->put($this->orderStreetKey, $request->street);
    	$request->session()->put($this->orderCityKey, $request->city);
    	$request->session()->put($this->orderPostcodeKey, $request->postcode);
    	$request->session()->put($this->orderCountryKey, $request->country);
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
     * Returns the order reference number.
     * 
     * @return String order reference number
     */
    public function getReferenceNumber()
    {
    	return 'OD'.$this->getShoppingCartId();
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
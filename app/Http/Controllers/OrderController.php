<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Order;
use Cart;
use CartAlreadyStoredException;

class OrderController extends Controller
{
    protected $merchantKey = 't31B7FOsuf';
    protected $merchantCode = 'M00568';

    /**
     * The Order instance.
     * @var App\Order
     */
	protected $order;

	/**
	 * Default constructor.
	 *
	 * @param Order $order App\Order
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

    /**
     * Return the index/checkout page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	return view('order.create')
                ->with('couponTotalValue', $request['coupon_total_value']);
    }

    /**
     * Store the Order instance.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $shoppingCartId = $this->getShoppingCartId();
        try {
            Cart::store($shoppingCartId);
        } catch (\Exception $e) {
            // Do nothing
        }
        
        $order = $this->order->where('shoppingcart_id', $shoppingCartId)->first();

        if ($order == null)
        {
            $order = $this->order;
            $order->name = $request['name'];
            $order->email = $request['email'];
            $order->phone_number = $request['phone_number'];
            $order->address = $this->getAddress($request['property_no'], 
                                                $request['street_address'], 
                                                $request['city'], 
                                                $request['country'], 
                                                $request['postcode']);
            $order->delivery_cost = 10.00;
            $order->coupon_total_value = $request['coupon_total_value'];
            $order->status = 'new';
            $order->shoppingcart_id = $shoppingCartId;
            $order->save();
        }

        session(['order_id' => $order->id]);

        return redirect('payment');
    }

    /**
     * Return constructed address text.
     *
     * @param  [type] $propertyNo    [description]
     * @param  [type] $streetAddress [description]
     * @param  [type] $city          [description]
     * @param  [type] $country       [description]
     * @param  [type] $postcode      [description]
     * @return [type]                [description]
     */
    private function getAddress($propertyNo, $streetAddress, $city, $country, $postcode)
    {
        return $propertyNo.', '.$streetAddress.', '.$postcode.', '.$city.', '.$country;
    }

    /**
     * Generate a unique shopping cart identifier.
     *
     * @return String   the unique shopping cart identifier
     */
    private function getShoppingCartId()
    {
        $toHashStr = '';
        
        foreach (Cart::content() as $c) {
            $toHashStr = $toHashStr.$c->rowId;
        }

        return sha1($toHashStr);
    }

    /**
     * Process order payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $order = $this->order->find($request->session()->get('order_id'));

        if ($order != null)
        {
            $merchantKey = $this->merchantKey;
            $merchantCode = $this->merchantCode;
            $refNo = 'OID'.$order->id;
            $amount = '1.00';
            $amountStr = str_replace(['.', ','], "", $amount);
            $currency = 'MYR';

            $shaStr = $this->iPay88_signature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);

            // dd($merchantKey.$merchantCode.$refNo.$amountStr.$currency.' : '.$shaStr);
            
            return view('order.payment')
                        ->with('order', $order)
                        ->with('merchantCode', $merchantCode)
                        ->with('refNo', $refNo)
                        ->with('amount', $amount)
                        ->with('currency', $currency)
                        ->with('sha', $shaStr);
        } else
        {
            return redirect('cart')->withMessage('Unable to find order');
        }
    }

    /**
     * Process payment response's POST request.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function paymentResponse(Request $request)
    {
    	$status = $request->Status;
    	$signature = $request->Signature;
    	$merchantCode = $request->MerchantCode;
    	$refNo = $request->RefNo;
    	$amountStr = $request->Amount;
    	$currency = $request->Currency;

    	if ($status == 1)
    	{
    		$shaStr = $this->iPay88_signature($merchantKey.$merchantCode.$refNo.$amountStr.$currency.$status);
    		if ($signature == $shaStr)
    		{
    			return view('cart.payment_response')->withMessage('Successful!');
    		} else 
    		{
    			return view('cart.payment_response')->withMessage('Failed!');
    		}
    	} else 
    	{
    		return view('cart.payment_response')->withMessage('Payment transaction failed!');
    	}
    }

    /**
     * Process Back End payment response's POST request.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function paymentResponseBE(Request $request)
    {
    	$status = $request->Status;
    	$signature = $request->Signature;
    	$merchantCode = $request->MerchantCode;
    	$refNo = $request->RefNo;
    	$amountStr = $request->Amount;
    	$currency = $request->Currency;

    	if ($status == 1)
    	{
    		$shaStr = $this->iPay88_signature($merchantKey.$merchantCode.$refNo.$amountStr.$currency.$status);
    		if ($signature == $shaStr)
    		{
    			echo 'RECEIVEOK';
    		} else 
    		{
    			return view('cart.payment_response_be')->withMessage('Failed!');
    		}
    	} else 
    	{
    		return view('cart.payment_response_be')->withMessage('Payment transaction failed!');
    	}
    }

    /**
     * Generate signature for ipay88 request.
     *
     * @param  [type] $source [description]
     * @return [type]         [description]
     */
    function iPay88_signature($source)
	{
       	return base64_encode(hex2bin(sha1($source)));
	}
	
	/**
	 * Generate signature for ipay88 request.
	 *
	 * @param  [type] $hexSource [description]
	 * @return [type]            [description]
	 */
	function hex2bin($hexSource)
	{
		for ($i=0;$i<strlen($hexSource);$i=$i+2)
		{
	       	$bin .= chr(hexdec(substr($hexSource,$i,2)));
		}
		return $bin;
	}
}

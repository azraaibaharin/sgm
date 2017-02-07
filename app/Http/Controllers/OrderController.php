<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Order;
use Auth;
use Cart;
use CartAlreadyStoredException;

class OrderController extends Controller
{
    protected $merchantKey = 't31B7FOsuf';
    protected $merchantCode = 'M00568';
    protected $orderIdKey = 'order_id';
    protected $orderEmailKey = 'order_email';
    protected $couponIdsKey = 'coupon_ids';
    protected $couponTotalValueKey = 'coupon_total_value';
    protected $deliveryCostKey = 'delivery_cost';
    protected $finalPriceKey = 'final_price';

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
     * Store order email to session and redirect to index.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function search(Request $request) 
    {
        $request->session()->put($this->orderEmailKey, $request['email']);
        return redirect('order');
    }

    /**
     * Displays a list of orders if admin is logged in. 
     * Else display list of order associated to the email stored in session.
     * Show nothing of no email is stored.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        $email = $request->session()->get($this->orderEmailKey);
        if ($email)
        {
            $orders = $this->order->where('email', $email)->get();
        } else
        {
            if (!Auth::guest())
            {
                $email = 'All';
                $orders = $this->order->all();
            } else 
            {
                $orders = [];
            }   
        }

        return view('order.index')
                ->with('orders', $orders)
                ->with('email', $email);
    }

    /**
     * Display the details of the order.
     * Only order with the same email as the stored email in session is allowed to be viewed.
     * Means only the last searched email's orders are viewable.
     *
     * @param  Request $request [description]
     * @param  [type]  $orderId [description]
     * @return [type]           [description]
     */
    public function show(Request $request, $orderId)
    {
        $email = $request->session()->get($this->orderEmailKey);
        $order = $this->order->find($orderId);
        if (is_null($order))
        {
            return redirect('order')->with('message', 'Order not found.');
        }

        if ($email != $order->email && Auth::guest())
        {
            return redirect('order')->with('error', 'You are not allowed to view that order.');   
        }

        $shoppingCartId = $order->shoppingcart_id;
        // Cart::instance($shoppingCartId);
        // Cart::restore($shoppingCartId);
        // $contents = Cart::content();
        // $total = Cart::total(2, '.', '');
        // Cart::destroy();

        return view('order.show')
                ->with('shoppingCartId', $shoppingCartId);
                // ->with('order', $order)
                // ->with('contents', $contents)
                // ->with('total', $total);
    }

    /**
     * Return the index/checkout page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	return view('order.create');
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
            $order->address = $this->getAddress($request['property_no'], $request['street_address'], $request['city'], $request['country'], $request['postcode']);
            $order->delivery_cost = $request->session()->get($this->deliveryCostKey);
            $order->coupon_total_value = $request->session()->get($this->couponTotalValueKey);
            $order->status = 'new';
            $order->shoppingcart_id = $shoppingCartId;
            $order->save();
        }

        session([$this->orderIdKey => $order->id]);

        return redirect('order/complete');
    }

    /**
     * Completes the order.
     * 1. Clear cart.
     * 2. Clear stored session data related to order: order_id, coupon_ids, coupon_total_value, delivery_cost, final_price.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function complete(Request $request)
    {
        $orderId = $request->session()->get($this->orderIdKey);
        $order = $this->order->find($orderId);

        if ($order)
        {
            Cart::destroy();
            session()->forget($this->orderIdKey);
            session()->forget($this->orderEmailKey);
            session()->forget($this->couponIdsKey);
            session()->forget($this->couponTotalValueKey);
            session()->forget($this->deliveryCostKey);
            session()->forget($this->finalPriceKey);
            $order->status = 'Paid';
            $order->save();
        } else 
        {
            return view('order.incomplete');
        }

        return view('order.complete')->with('orderId', $orderId);
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
        $merchantKey = $this->merchantKey;
        $merchantCode = $this->merchantCode;
        $refNo = 'OID0001';
        $amount = '1.00';
        $amountStr = str_replace(['.', ','], "", $amount);
        $currency = 'MYR';

        $shaStr = $this->iPay88_signature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);

        // dd($merchantKey.$merchantCode.$refNo.$amountStr.$currency.' : '.$shaStr);
        
        return view('order.payment_test')
                    // ->with('order', $order)
                    ->with('merchantCode', $merchantCode)
                    ->with('refNo', $refNo)
                    ->with('amount', $amount)
                    ->with('currency', $currency)
                    ->with('sha', $shaStr);

        // $order = $this->order->find($request->session()->get($this->orderIdKey));

        // if ($order != null)
        // {
        //     $merchantKey = $this->merchantKey;
        //     $merchantCode = $this->merchantCode;
        //     $refNo = 'OID'.$order->id;
        //     $amount = '1.00';
        //     $amountStr = str_replace(['.', ','], "", $amount);
        //     $currency = 'MYR';

        //     $shaStr = $this->iPay88_signature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);

        //     // dd($merchantKey.$merchantCode.$refNo.$amountStr.$currency.' : '.$shaStr);
            
        //     return view('order.payment')
        //                 ->with('order', $order)
        //                 ->with('merchantCode', $merchantCode)
        //                 ->with('refNo', $refNo)
        //                 ->with('amount', $amount)
        //                 ->with('currency', $currency)
        //                 ->with('sha', $shaStr);
        // } else
        // {
        //     return redirect('cart')->withMessage('Unable to find order');
        // }
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

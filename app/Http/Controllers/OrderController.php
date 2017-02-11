<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreOrder;
use App\Order;
use App\Traits\HandlesOrder;
use Auth;
use Cart;
use CartAlreadyStoredException;

class OrderController extends Controller
{
    use HandlesOrder;

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
     * Displays a list of orders if admin is logged in. 
     * 
     * @param  Request $request
     * @return \Illumninate\Http\Response
     */
    public function index(Request $request)
    {
        return view('order.index')->with('orders', $this->order->all());
    }

    /**
     * Display the details of the order.
     *
     * @param  Request $request
     * @param  String  $orderId
     * @return \Illumninate\Http\Response
     */
    public function show(Request $request, $orderId)
    {
        $order = $this->order->findOrFail($orderId);

        return view('order.show')->with('order', $order);
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
     * @param  StoreOrder $request [description]
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        $this->saveToSession($request);
        // $shoppingCartId = $this->getShoppingCartId();
        // $order = $this->order->where('shoppingcart_id', $shoppingCartId)->first();

        // if ($order == null)
        // {
        //     $order = $this->order;
        //     $order->name = $request->name;
        //     $order->email = $request->email;
        //     $order->phone_number = $request->phone_number;
        //     $order->address = $this->getAddress($request);
        //     $order->delivery_cost = $this->getDeliveryCost();
        //     $order->coupon_total_value = $this->getCouponTotalValue();
        //     $order->status = 'new';
        //     $order->shoppingcart_id = $shoppingCartId;
        //     $order->reference_number = 'OD'.$shoppingCartId;
        //     $order->save();

        //     $request->session()->put($this->orderIdKey, $order->id);
        // }

        return redirect('payment');
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
     * Process order payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $merchantKey  = config('payment.merchant_key');
        $merchantCode = config('payment.merchant_code');
        $refNo        = $this->getReferenceNumber();
        $amount       = '1.00';
        $amountStr    = str_replace(['.', ','], "", $amount);
        $currency     = config('payment.currency');
        $signature    = $this->getSignature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);

        return view('order.payment')
                    ->with('merchantCode', $merchantCode)
                    ->with('refNo', $refNo)
                    ->with('amount', $amount)
                    ->with('currency', $currency)
                    ->with('signature', $signature)
                    ->with('couponTotalValue', $this->getCouponTotalValue($request))
                    ->with('deliveryCost', $this->getDeliveryCost())
                    ->with('finalPrice', $this->getFinalPrice($this->getCouponTotalValue($request), $this->getDeliveryCost()))
                    ->with('name', $this->getName($request))
                    ->with('email', $this->getEmail($request))
                    ->with('phoneNumber', $this->getPhoneNumber($request))
                    ->with('address', $this->getAddress($request));
    }

    /**
     * Process payment response's POST request.
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function paymentResponse(Request $request)
    {
        $merchantKey = config('payment.merchant_key');
        $merchantCode = config('payment.merchant_code');
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
    			return view('order.payment_response')->withMessage('Successful!');
    		} else 
    		{
    			return view('order.payment_response')->withMessage('Failed!');
    		}
    	} else 
    	{
    		return view('order.payment_response')->withMessage('Payment transaction failed!');
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
        $merchantKey = config('payment.merchant_key');
        $merchantCode = config('payment.merchant_code');
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
    			return view('order.payment_response')->withMessage('Failed!');
    		}
    	} else 
    	{
    		return view('order.payment_response')->withMessage('Payment transaction failed!');
    	}
    }
}

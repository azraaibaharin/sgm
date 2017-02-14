<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

use App\Http\Requests\StoreOrder;
use App\Http\Requests\UpdateOrder;
use App\Traits\HandlesOrder;
use App\Traits\FlashModelAttributes;
use App\Order;
use App\Configuration;
use Auth;
use Cart;

class OrderController extends Controller
{
    use HandlesOrder, FlashModelAttributes;

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
        Log::info('Showing order id: '.$orderId);

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

        return redirect('payment');
    }

    /**
     * Edit Order.
     * 
     * @param  Request $request
     * @param  String  $id      
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        Log::info('Editing order id: '.$id);

        $this->flashAttributesToSession($request, $this->order->findOrFail($id));

        return view('order.edit')->with('statuses', 
            ['payment unsuccessful', 'payment successful', 'payment received', 'order processed', 'order shipped']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrder  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrder $request, $id)
    {   
        Log::info('Updating order: '.$id);

        $toUpdateOrder               = $this->order->findOrFail($id);
        $toUpdateOrder->name         = $request->name;
        $toUpdateOrder->email        = $request->email;
        $toUpdateOrder->phone_number = $request->phone_number;
        $toUpdateOrder->address      = $request->address;
        $toUpdateOrder->status       = $request->status;
        
        $toUpdateOrder->save();

        return redirect('order/'.$id)->withMessage('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info('Removing order id: '.$request->order_id);

        $orderId    = $request->order_id;
        $orderRefno = $this->order->findOrFail($orderId)->reference_number;
        
        $this->order->destroy($orderId);

        return redirect('order')->withMessage('Deleted \''.$orderRefno.'\'');
    }

    /**
     * Process order payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        Log::info('Preparing review / payment page');

        $merchantKey      = config('payment.merchant_key');
        $merchantCode     = config('payment.merchant_code');
        $refNo            = $this->getReferenceNumber();
        $amount           = '1.00';
        $amountStr        = str_replace(['.', ','], "", $amount);
        $currency         = config('payment.currency');
        $signature        = $this->getSignature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);
        $deliveryCost     = $this->getDeliveryCost();
        $couponTotalValue = $this->getCouponTotalValue($request);

        return view('order.payment')
                    ->with('merchantCode', $merchantCode)
                    ->with('refNo', $refNo)
                    ->with('amount', $amount)
                    ->with('currency', $currency)
                    ->with('signature', $signature)
                    ->with('couponTotalValue', $couponTotalValue)
                    ->with('deliveryCost', $deliveryCost)
                    ->with('finalPrice', $this->getFinalPrice($couponTotalValue, $deliveryCost))
                    ->with('name', $this->getName($request))
                    ->with('email', $this->getEmail($request))
                    ->with('phoneNumber', $this->getPhoneNumber($request))
                    ->with('address', $this->getAddress($request));
    }

    /**
     * Process payment response's POST request.
     *
     * @param  Request $request 
     * @return \Illuminate\Http\Response
     */
    public function paymentResponse(Request $request)
    {
        Log::info('Processing payment response. Reference number: '.$request->RefNo);

        $merchantKey     = config('payment.merchant_key');
        $merchantCode    = config('payment.merchant_code');
        $status          = $request->Status;
        $signature       = $request->Signature;
        $merchantCode    = $request->MerchantCode;
        $refNo           = $request->RefNo;
        $amount          = $request->Amount;
        $amountStr       = str_replace(['.', ','], "", $amount);
        $currency        = $request->Currency;
        $ownSignatureRaw = $merchantKey.$merchantCode.$refNo.$amountStr.$currency.$status);
        $isSuccess       = $status == 1 && $this->isValidSignature($signature, $ownSignatureRaw);
        $orderStatus     = $isSuccess ? 'payment succesful' : 'payment unsuccessful';
        $message         = 'Payment transaction was incomplete. Please contact '.Configuration::emailSales()->first()->value.' for assistance.';

        Log::info('Payment response status: '.$status);
        Log::info('Payment response signature: '.$signature);
        Log::info('Payment response ref number: '.$refNo);
        Log::info('Payment response amount: '.$amount);
        Log::info('Payment signature: '.$this->getSignature($ownSignatureRaw);

    	if ($isSuccess)
    	{
            $message = 'Thank you for the payment!. Your order is currently being processed.';
    	}

        $order = $this->storeFromSession($request, $orderStatus, $refNo);    
        $this->sendEmail($request, $order);
        $this->clearOrder($request);
        $this->clearCart($request);
        $this->clearCoupons($request);

        return view('order.complete')
                    ->with('referenceNumber', $refNo)
                    ->with('message', $message)
                    ->with('isSuccess', $isSuccess);
    }

    /**
     * Process Back End payment response's POST request.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function paymentResponseBE(Request $request)
    {
        Log::info('Processing payment back end response. Reference number: '.$request->RefNo);

        $merchantKey  = config('payment.merchant_key');
        $merchantCode = config('payment.merchant_code');
        $status       = $request->Status;
        $signature    = $request->Signature;
        $merchantCode = $request->MerchantCode;
        $refNo        = $request->RefNo;
        $amountStr    = $request->Amount;
        $currency     = $request->Currency;
        $isSuccess    = $status == 1 && $this->isValidSignature($signature, $merchantKey.$merchantCode.$refNo.$amountStr.$currency.$status);
        $message      = 'Payment transaction was incomplete';

        if ($isSuccess)
        {
            echo 'RECEIVEOK';
        }

    	return view('order.complete')
                    ->withReferenceNumber($refNo)
                    ->withMessage($message)
                    -withIsSuccess($isSuccess);
    }
}

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
        return view('order.index')->with('orders', $this->order->orderBy('created_at', 'desc')->get());
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
    	return view('order.create')->with('states', $this->getStates());
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
        $refNo            = $request->session()->get($this->orderReferenceNumberKey);
        $amount           = $request->session()->get($this->orderFinalPriceKey);
        $amountStr        = str_replace(['.', ','], "", $amount);
        $currency         = config('payment.currency');
        $signature        = $this->getSignature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);
        $orderStatus      = 'payment incomplete';

        $order = $this->storeFromSession($request, $orderStatus, $refNo);
        $this->storeToFile($order);
        $this->sendEmail($request, $order);
        $this->sendSupportEmail($request, $order);

        return view('order.payment')
                    ->with('merchantCode', $merchantCode)
                    ->with('refNo', $refNo)
                    ->with('amount', $amount)
                    ->with('currency', $currency)
                    ->with('signature', $signature);
    }

    /**
     * Process order payment test.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentTest(Request $request)
    {
        Log::info('Preparing payment test page');

        $request->session()->put($this->orderNameKey, 'orderNameTest');
        $request->session()->put($this->orderEmailKey, 'orderEmail@Test.com');
        $request->session()->put($this->orderPhoneNumberKey, '011-orderPhoneNumberTest');
        $request->session()->put($this->orderAddressKey, 'orderAddressTest');
        $request->session()->put($this->orderDeliveryCostKey, 1.00);
        $request->session()->put($this->orderShoppingCartIdKey, 'orderShoppingCartIdTest');
        $request->session()->put($this->couponTotalValueKey, 0.00);
        $request->session()->put($this->orderTotalPriceKey, 1.00);
        $request->session()->put($this->orderFinalPriceKey, 1.00);

        $merchantKey      = config('payment.merchant_key');
        $merchantCode     = config('payment.merchant_code');
        $refNo            = $this->constructReferenceNumber();
        $amount           = '1.00';
        $amountStr        = str_replace(['.', ','], "", $amount);
        $currency         = config('payment.currency');
        $signature        = $this->getSignature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);

        $this->sendSupportEmail($request, $this->storeFromSession($request, 1, $refNo));
        return view('order.payment_test')
                    ->with('merchantCode', $merchantCode)
                    ->with('refNo', $refNo)
                    ->with('amount', $amount)
                    ->with('currency', $currency)
                    ->with('signature', $signature);
    }

    /**
     * Prepare payment response test page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function paymentTestResponse(Request $request)
    {
        Log::info('Preparing payment response test page');

        $request->session()->put($this->orderNameKey, 'orderNameTest');
        $request->session()->put($this->orderEmailKey, 'orderEmail@Test.com');
        $request->session()->put($this->orderPhoneNumberKey, '011-orderPhoneNumberTest');
        $request->session()->put($this->orderAddressKey, 'orderAddressTest');
        $request->session()->put($this->orderDeliveryCostKey, 1.00);
        $request->session()->put($this->orderShoppingCartIdKey, 'orderShoppingCartIdTest');
        $request->session()->put($this->couponTotalValueKey, 0.00);
        $request->session()->put($this->orderTotalPriceKey, 1.00);
        $request->session()->put($this->orderFinalPriceKey, 1.00);

        $merchantKey      = config('payment.merchant_key');
        $merchantCode     = config('payment.merchant_code');
        $refNo            = 'ODdJmnT5cM1490970558';
        $status           = '1';
        $amount           = '1.00';
        $currency         = 'MYR';
        $amountStr        = str_replace(['.', ','], "", $amount);
        $paymentId        = '6';
        $signature        = $this->getSignature($merchantKey.$merchantCode.$paymentId.$refNo.$amountStr.$currency.$status);
        
        return view('order.payment_response_test')
                    ->with('merchantCode', $merchantCode)
                    ->with('refNo', $refNo)
                    ->with('status', $status)
                    ->with('amount', $amount)
                    ->with('currency', $currency)
                    ->with('signature', $signature)
                    ->with('paymentId', $paymentId);
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

        $merchantKey      = config('payment.merchant_key');
        $merchantCode     = config('payment.merchant_code');
        $status           = $request->Status;
        $signature        = $request->Signature;
        $respMerchantCode = $request->MerchantCode;
        $paymentId        = $request->PaymentId;
        $refNo            = $request->RefNo;
        $amount           = $request->Amount;
        $currency         = $request->Currency;
        $amountStr        = str_replace(['.', ','], "", $amount);
        $ownSignatureRaw  = $merchantKey.$respMerchantCode.$paymentId.$refNo.$amountStr.$currency.$status;
        $isSuccess        = $status == 1 && $this->isValidSignature($signature, $ownSignatureRaw);
        $orderStatus      = $isSuccess ? 'payment succesful' : 'payment unsuccessful';
        $defaultMessage   = 'Payment transaction was incomplete. Please contact '.Configuration::emailSales()->first()->value.' for assistance.';
        $message          = $defaultMessage;

        Log::info('Payment response status: '.$status);
        Log::info('Payment response signature: '.$signature);
        Log::info('Payment response payment id: '.$paymentId);
        Log::info('Payment response ref number: '.$refNo);
        Log::info('Payment response amount: '.$amount);
        Log::info('Payment response currency: '.$currency);
        Log::info('Payment response merchant code: '.$respMerchantCode);
        Log::info('Payment own signature: '.$this->getSignature($ownSignatureRaw));

    	if ($isSuccess)
    	{
            $message = 'Thank you for the payment!. Your order is currently being processed.';
    	}

        try 
        {
            $order = $this->updateOrderStatus($orderStatus, $refNo);    
            $this->updateOrderFile($order);
            $this->sendEmail($request, $order);
            $this->sendSupportEmail($request, $order);
        } 
        catch (\Exception $ex) 
        {
            Log::error('Error in post payment processes: '.$ex);
        } 
        finally 
        {
            $this->clearOrder($request);
            $this->clearCart($request);
            $this->clearCoupons($request);
        }

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

        $merchantKey      = config('payment.merchant_key');
        $merchantCode     = config('payment.merchant_code');
        $status           = $request->Status;
        $signature        = $request->Signature;
        $respMerchantCode = $request->MerchantCode;
        $paymentId        = $request->PaymentId;
        $refNo            = $request->RefNo;
        $amount           = $request->Amount;
        $currency         = $request->Currency;
        $amountStr        = str_replace(['.', ','], "", $amount);
        $ownSignatureRaw  = $merchantKey.$respMerchantCode.$paymentId.$refNo.$amountStr.$currency.$status;
        $isSuccess        = $status == 1 && $this->isValidSignature($signature, $ownSignatureRaw);
        $message          = 'Payment transaction was incomplete';

        Log::info('Payment BE response status: '.$status);
        Log::info('Payment BE response signature: '.$signature);
        Log::info('Payment BE response payment id: '.$paymentId);
        Log::info('Payment BE response ref number: '.$refNo);
        Log::info('Payment BE response amount: '.$amount);
        Log::info('Payment BE response currency: '.$currency);
        Log::info('Payment BE response merchant code: '.$respMerchantCode);
        Log::info('Payment BE own signature: '.$this->getSignature($ownSignatureRaw));

        if ($isSuccess)
        {
            echo 'RECEIVEOK';
        }

    	return view('order.complete')
                    ->withReferenceNumber($refNo)
                    ->withMessage($message)
                    ->withIsSuccess($isSuccess);
    }
}

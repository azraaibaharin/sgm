<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cart;

class CartController extends Controller
{

	protected $merchantKey = 't31B7FOsuf';
	protected $merchantCode = 'M00568';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Cart::add($request->id, $request->name, 1, $request->price);
	    return redirect('cart')->withSuccessMessage('Item was added to your cart!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $rowId cart item row id
     * @return \Illuminate\Http\Response
     */
    public function add($rowId)
    {
        $cartItem = Cart::get($rowId);
        $newCount = $cartItem->qty + 1;
        Cart::update($rowId, $newCount);
        return redirect('cart')->withSuccessMessage('Item count has been increased!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $rowId cart item row id
     * @return \Illuminate\Http\Response
     */
    public function remove($rowId)
    {
        $cartItem = Cart::get($rowId);
        $newCount = $cartItem->qty - 1;
        Cart::update($rowId, $newCount);
        return redirect('cart')->withSuccessMessage('Item count has been decreased!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rowId)
    {
        Cart::remove($rowId);
	    return redirect('cart')->withSuccessMessage('Item has been removed!');
    }

    /**
     * Remove all cart item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function empty()
    {
        Cart::destroy();
     	return redirect('cart')->withSuccessMessage('Items has been removed!');   
    }

    /**
     * Process cart payment.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
    	$merchantKey = $this->merchantKey;
    	$merchantCode = $this->merchantCode;
    	$refNo = 'A00000001';
    	$amount = '1.00';
    	$amountStr = str_replace(['.', ','], "", $amount);
    	$currency = 'MYR';

    	$shaStr = $this->iPay88_signature($merchantKey.$merchantCode.$refNo.$amountStr.$currency);

    	// dd($merchantKey.$merchantCode.$refNo.$amountStr.$currency.' : '.$shaStr);

     	return view('cart.payment')
     				->with('merchantCode', $merchantCode)
     				->with('refNo', $refNo)
     				->with('amount', $amount)
     				->with('currency', $currency)
     				->with('sha', $shaStr);
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
       	// return base64_encode(hex2bin(sha1($source)));
       	return sha1($source);
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

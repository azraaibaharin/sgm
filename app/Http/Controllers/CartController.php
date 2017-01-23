<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cart;

class CartController extends Controller
{
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
}

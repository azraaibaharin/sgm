<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

use App\Traits\HandlesCart;
use Cart;

class CartController extends Controller
{
    use HandlesCart;

    /**
     * Show cart items.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        Log::info('Showing cart');

        $this->prepareForShow($request);

        return view('cart.show');
    }

    /**
     * Add a product to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {
        Log::info('Adding product '.$request->name.' to cart');

		Cart::add($request->id, $request->name, 1, $request->price, ['color' => $request->color, 'delivery_weight' => $request->delivery_weight]);

	    return redirect('cart')->withMessage('Added \''.$request->name.'\'!');
    }

    /**
     * Increase the quantity of the specified cart item by one, based on the provided row id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $rowId cart item row id
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, $rowId)
    {
        Log::info('Adding 1 count of cart item id: '.$rowId);

        $cartItem = Cart::get($rowId);
        $newCount = $cartItem->qty + 1;
        Cart::update($rowId, $newCount);

        return redirect('cart')->withMessage('Added \''.$cartItem->name.'\'!');
    }

    /**
     * Decrease the quantity of the specified cart item by one, based on the provided row id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $rowId cart item row id
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, $rowId)
    {
        Log::info('Removing 1 count of cart item id: '.$rowId);

        $cartItem = Cart::get($rowId);
        $newCount = $cartItem->qty - 1;
        Cart::update($rowId, $newCount);

        if (Cart::count() < 1)
        {
            $this->clearCoupons($request);
        }

        return redirect('cart')->withMessage('Removed \''.$cartItem->name.'\'!');
    }

    /**
     * Remove all cart items from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function empty(Request $request)
    {
        Log::info('Emptying cart');

        Cart::destroy();
        $this->clearCoupons($request);

     	return redirect('cart')->withMessage('Cart is emptied');   
    }
}

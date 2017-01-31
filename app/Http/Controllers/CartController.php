<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use \Carbon\Carbon;
use Cart;
use Hash;
use App\Coupon;

class CartController extends Controller
{
    protected $couponIdsKey = 'coupon_ids';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // session([$this->couponIdsKey => '']);
        $couponIds = session($this->couponIdsKey, '');
        $couponTotalValue = $this->getCouponTotalValue(explode(',', $couponIds));

        return view('cart.index')
                ->with('couponTotalValue', $couponTotalValue)
                ->with('couponIds', $couponIds);
    }

    /**
     * Return total value of coupons based on the collection of coupon IDs.
     *
     * @param  Collection $couponIdsArr a collection of coupon id
     * @return [type]                [description]
     */
    private function getCouponTotalValue($couponIdsArr)
    {
        $value = 0;
        
        foreach($couponIdsArr as $couponId)
        {
            $coupon = Coupon::find($couponId);
            if ($coupon != null && $this->isCouponValid($coupon))
            {
                $value += $coupon->value;
            }
        }

        return $value;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		Cart::add($request->id, $request->name, 1, $request->price, ['color' => $request['color']]);
	    return redirect('cart')->withMessage('Added \''.$request['name'].'\'!');
    }

    /**
     * Increase the quantity of the specified cart item by one, based on the provided row id.
     *
     * @param  int  $rowId cart item row id
     * @return \Illuminate\Http\Response
     */
    public function add($rowId)
    {
        $cartItem = Cart::get($rowId);
        $newCount = $cartItem->qty + 1;
        Cart::update($rowId, $newCount);
        return redirect('cart')->withMessage('Added \''.$cartItem->name.'\'!');
    }

    /**
     * Decrease the quantity of the specified cart item by one, based on the provided row id.
     *
     * @param  int  $rowId cart item row id
     * @return \Illuminate\Http\Response
     */
    public function remove($rowId)
    {
        $cartItem = Cart::get($rowId);
        $newCount = $cartItem->qty - 1;
        Cart::update($rowId, $newCount);
        return redirect('cart')->withMessage('Removed \''.$cartItem->name.'\'!');
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
	    return redirect('cart')->withMessage('Item has been removed!');
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
     	return redirect('cart')->withMessage('All items has been removed!');   
    }

    /**
     * Add coupon to the cart.
     *
     * @param Request $request [description]
     */
    public function addCoupon(Request $request)
    {
        $couponCode = $request['coupon_code'];
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon != null && $this->isCouponValid($coupon))
        {
            $couponIds = session($this->couponIdsKey, '');
            if(!$this->isCouponUsed($couponIds, $coupon->id))
            {
                if ($couponIds == '')
                {
                    $couponIds = $coupon->id;
                } else
                {
                    $couponIds = $couponIds.','.$coupon->id;                    
                }

                session([$this->couponIdsKey => $couponIds]);
                return redirect('cart')->withSuccess('Coupon code \''.$couponCode.'\' applied');
            } else
            {
                return redirect('cart')->withError('Coupon code has been used!');
            }
        } else 
        {
            return redirect('cart')->withError('Coupon code is invalid');
        }
    }

    /**
     * Checks whether a coupon has been used by checking the used coupon ids collection.
     *
     * @param  Collection  $couponIds the collection of used coupon ids to check against
     * @param  String      $couponId  the coupon id to check if used
     * @return boolean            [description]
     */
    private function isCouponUsed($couponIds, $couponId)
    {
        $isUsed = false;
        
        foreach(explode(',', $couponIds) as $cid)
        {
            if($couponId == $cid)
            {
                $isUsed = true;
                break;
            }
        }

        return $isUsed;
    }

    /**
     * Checks whether the coupon still valid by comparing the current date with the expiry date.
     *
     * @param  Coupon  $coupon App/Coupon instance
     * @return boolean         whether the coupon is still valid
     */
    private function isCouponValid(Coupon $coupon)
    {
        $now = Carbon::now();
        $couponExpireDate = new Carbon($coupon->date_of_expiration);
        return $couponExpireDate >= $now;
    }
}

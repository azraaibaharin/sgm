<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Coupon;

class CouponController extends Controller
{
    /**
     * The Coupon instance.
     * @var App/Coupon
     */
    protected $coupon;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = $this->coupon->all();
        return view('coupon.index')->with('coupons', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = $this->coupon;
        $coupon->code = $request['code'];
        $coupon->discount = $request['discount'];
        $coupon->value = $request['value'];
        $coupon->date_of_issue = $this->toDate($request['date_of_issue']);
        $coupon->date_of_expiration = $this->toDate($request['date_of_expiration']);
        $coupon->save();

        return redirect('coupons')->with('message', 'Coupon created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $coupon = $this->coupon->find($id);
        if (is_null($coupon))
        {
            return redirect('coupons')->with('message', 'Coupon not found.');
        }
        return view('coupon.show', $coupon->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = $this->coupon->find($id);
        if (is_null($coupon))
        {
            return redirect('coupons')->with('message', 'Coupon not found.');
        }
        return view('coupon.edit', $coupon->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = $this->coupon->find($id);
        if (is_null($coupon))
        {
            return redirect('coupons')->with('message', 'Coupon not found.');
        }

        $coupon->code = $request['code'];
        $coupon->discount = $request['discount'];
        $coupon->value = $request['value'];
        $coupon->date_of_issue = $this->toDate($request['date_of_issue']);
        $coupon->date_of_expiration = $this->toDate($request['date_of_expiration']);
        $coupon->save();

        return redirect('coupons')->with('message','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $coupon_id = $id;
        $coupon = $this->coupon->find($coupon_id);
        if (is_null($coupon))
        {
            return redirect('coupons')->with('message', 'Coupon not found.');
        }
        $couponCode = $coupon->code;
        $this->coupon->destroy($coupon_id);

        return redirect('coupons')->with('message', 'Successfully deleted \''.$couponCode.'\'');
    }

    /**
     * Converts date string to date object with the following date format: Y-m-d.
     *
     * @param  String $dateStr the date in String representation
     * @return an instance of date object
     */
    private function toDate($dateStr) 
    {
        $time = strtotime($dateStr);
        return date('Y/m/d', $time);
    }
}

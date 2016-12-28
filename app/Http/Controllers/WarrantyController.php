<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Warranty;

class WarrantyController extends Controller
{
    /**
     * The Warranty instance.
     * @var App/Warranty
     */
    protected $warranty;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Warranty $warranty)
    {
        $this->warranty = $warranty;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warranties = $this->warranty->orderBy('updated_at')->get();
        return view('warranty.index')->with('warranties', $warranties);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warranty.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $warranty = $this->warranty;
        $warranty->full_name = $request['full_name'];
        $warranty->email = $request['email'];
        $warranty->phone_number = $request['phone_number'];
        $warranty->address = $request['address'];
        $warranty->product_model_name = $request['product_model_name'];
        $warranty->product_serial_number = $request['product_serial_number'];
        $warranty->date_of_manufacture = $this->toDate($request['date_of_manufacture']);
        $warranty->date_of_purchase = $this->toDate($request['date_of_purchase']);
    
        $warranty->save();

        return redirect('warranties/'.$warranty->id);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $warranty = $this->warranty->find($id);
        if (is_null($warranty))
        {
            return redirect('home')->with('message', 'Warranty not found.');
        }
        return view('warranty.show', $warranty->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warranty = $this->warranty->find($id);
        if (is_null($warranty))
        {
            return redirect('home')->with('message', 'Warranty not found.');
        }
        return view('warranty.edit', $warranty->toArray());
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
        $warranty = $this->warranty->find($id);
        if (is_null($warranty))
        {
            return redirect('warranties')->with('message', 'Warranty not found.');
        }

        $warranty->full_name = $request['full_name'];
        $warranty->email = $request['email'];
        $warranty->phone_number = $request['phone_number'];
        $warranty->address = $request['address'];
        $warranty->product_model_name = $request['product_model_name'];
        $warranty->product_serial_number = $request['product_serial_number'];
        $warranty->date_of_manufacture = $this->toDate($request['date_of_manufacture']);
        $warranty->date_of_purchase = $this->toDate($request['date_of_purchase']);
    
        $warranty->save();

        return redirect('warranties/'.$warranty->id)->with('success','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $warranty_id = $request['warranty_id'];
        $warranty = $this->warranty->findOrFail($warranty_id);
        $warrantyDetails = $warranty->product_model_name.'. Serial no: '.$warranty->product_serial_number;
        $this->warranty->destroy($warranty_id);

        return redirect('warranties')->with('message', 'Successfully deleted \''.$warrantyDetails.'\'');
    }
}

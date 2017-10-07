<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Carbon\Carbon;
use Log;

use App\Http\Requests\StoreWarranty;
use App\Traits\FlashModelAttributes;
use App\Http\Requests;
use App\Warranty;

class WarrantyController extends Controller
{
    use FlashModelAttributes;

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
        $warranties = $this->warranty->orderBy('created_at', 'desc')->get();
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
     * @param  \App\Http\Requests\StoreWarranty  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWarranty $request)
    {
        Log::info('Storing warranty.');

        $warranty                        = $this->warranty;
        $warranty->full_name             = $request->full_name;
        $warranty->email                 = $request->email;
        $warranty->phone_number          = $request->phone_number;
        $warranty->address               = $request->address;
        $warranty->product_model_name    = $request->product_model_name;
        $warranty->product_model_number  = $request->product_model_number;
        $warranty->product_serial_number = $request->product_serial_number;
        $warranty->date_of_manufacture   = $this->toDate("1988-06-06");
        $warranty->date_of_purchase      = $this->toDate($request->date_of_purchase);

        $warranty->save();

        return redirect('warranties/'.$warranty->id)->withMessage('Registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Showing warranty id: '.$id);

        $warranty = $this->warranty->findOrFail($id);
        return view('warranty.show', $warranty->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        Log::info('Editing warranty id: '.$id);

        $this->flashAttributesToSession($request, $this->warranty->findOrFail($id));

        return view('warranty.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreWarranty  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWarranty $request, $id)
    {
        Log::info('Updating warranty id: '.$id);

        $warranty                        = $this->warranty->findOrFail($id);
        $warranty->full_name             = $request->full_name;
        $warranty->email                 = $request->email;
        $warranty->phone_number          = $request->phone_number;
        $warranty->address               = $request->address;
        $warranty->product_model_name    = $request->product_model_name;
        $warranty->product_model_number  = $request->product_model_number;
        $warranty->product_serial_number = $request->product_serial_number;
        $warranty->date_of_manufacture   = $this->toDate("1988-06-06");
        $warranty->date_of_purchase      = $this->toDate($request->date_of_purchase);
    
        $warranty->save();

        return redirect('warranties/'.$warranty->id)->withMessage('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info('Removing warranty id: '.$request->warranty_id);

        $warrantyId      = $request->warranty_id;
        $warranty        = $this->warranty->findOrFail($warrantyId);
        $warrantyDetails = $warranty->product_model_name.'. Serial no: '.$warranty->product_serial_number;

        $this->warranty->destroy($warrantyId);

        return redirect('warranties')->withMessage('Successfully deleted \''.$warrantyDetails.'\'');
    }

    /**
     * Exports the list of warranties as a file.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $warranties = $this->warranty->all();
        $exportFilename = 'warranties_export_'.Carbon::now()->toDateString().'.csv';

        Log::info('Exporting '.count($warranties).' warranties to '.$exportFilename);

        Excel::create($exportFilename, function($excel) use($warranties) {
            $excel->sheet('All', function($sheet) use($warranties) {
                $sheet->fromModel($warranties);
            });
        })->download('csv');

        return redirect('warranties')->withMessage('Successfully exported warranties to \''.$exportFilename.'\'');
    }

    /**
     * Remove all warranties.
     * 
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function clear(Request $request)
    {
        $warrantiesCount = $this->warranty->count();
        Log::info('Clearing '.$warrantiesCount.' rows of warranty');

        $this->warranty->truncate();
        
        return redirect('warranties')->withMessage('Successfully cleared '.$warrantiesCount.' warranties.');
    }

    /**
     * Converts date string to date object with the following date format: Y-m-d.
     *
     * @param  String $dateStr the date in String representation
     * @return an instance of date object
     */
    private function toDate($dateStr) 
    {
        return date('Y/m/d', strtotime($dateStr));
    }
}
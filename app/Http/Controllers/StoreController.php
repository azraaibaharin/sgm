<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Traits\FiltersStore;
use App\Traits\FlashModelAttributes;
use App\Http\Requests;
use App\Store;

class StoreController extends Controller
{
    use FlashModelAttributes, FiltersStore;

    /**
     * The Store instance.
     * @var App\Article
     */
    protected $store;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $state = null)
    {
        $store = $this->store;
        $states = $store->getStatesOptions();
        $state = is_null($state) && empty($state) ? $states[0] : $state;
        $stores = $this->getStoresByState($state, 100);

        $request->session()->flash('state', $state);

        return view('store.index')
                ->with('stores', $stores)
                ->with('states', $states);
    }

    /**
     * Display a listing of resource based on selected filter.
     *
     * @return \Illumninate\Http\Response
     */
    public function filter(Request $request) 
    {
        $store = $this->store;
        $states = $store->getStatesOptions();
        $state = $request->state;
        $stores = $this->getStoresByState($state, 100);

        $request->session()->flash('state', $state);

        return view('store.index')
                ->with('stores', $stores)
                ->with('states', $states);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('store.create')->with('states', $this->store->getStates());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('Storing store.');

        $store = $this->store;
        $store->name = $request->name;
        $store->phone_number = $request->phone_number;
        $store->lat = $request->lat;
        $store->lng = $request->lng;
        $store->address = $request->address;
        $store->city = $request->city;
        $store->state = $request->state;
        $store->brands = count($request->brands) > 0 ? implode(",", $request->brands) : '';
        $store->save();

        return redirect('stores/'.$store->id)->withMessage('');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Showing store id: '.$id);

        $store = $this->store->findOrFail($id);
        
        return view('store.show', $store->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        Log::info('Editing store id: '.$id);
        
        $this->flashAttributesToSession($request, $this->store->findOrFail($id));
    
        return view('store.edit');
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
        Log::info('Updating store id: '.$id);

        $store = $this->store->findOrFail($id);
        $store->name = $request->name;
        $store->phone_number = $request->phone_number;
        $store->brands = count($request->brands) > 0 ? implode(",", $request->brands) : '';
        $store->lat = $request->lat;
        $store->lng = $request->lng;
        $store->address = $request->address;
        $store->city = $request->city;
        $store->state = $request->state;
        $store->save();

        return redirect('stores/'.$store->id)->withMessage('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info('Deleting store id: '.$request->store_id);

        $storeId = $request->store_id;
        $store = $this->store->findOrFail($storeId);
        $storeName = $store->name;
        $this->store->destroy($storeId);

        return redirect('stores')->withMessage('Deleted \''.$storeName.'\'');
    }
}

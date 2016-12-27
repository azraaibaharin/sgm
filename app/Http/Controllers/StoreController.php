<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Store;

class StoreController extends Controller
{

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
     * Display a listing of resource based on selected filter.
     *
     * @return \Illumninate\Http\Response
     */
    public function filter(Request $request) 
    {
        $store = $this->store;
        $states = $store->getStatesOptions();
        $state = $request['state'];
        $stores = $store->when($state != $states[0], function ($query) use ($state) {
                                return $query->where('state', $state);}
                            )->orderBy('name', 'asc')->get();

        return view('store.index')
                ->with('stores', $stores)
                ->with('states', $states)
                ->with('state', $state);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $state = null)
    {
        $store = $this->store;
        $stores = [];
        $states = $store->getStatesOptions();

        if (!is_null($state) && !empty($state))
        {
            $stores = $store->where('state', $state)->orderBy('name', 'asc')->get();
        } else
        {
            $state = $states[0];
            $stores = $store->orderBy('name', 'asc')->get();
        }

        return view('store.index')
                ->with('stores', $stores)
                ->with('states', $states)
                ->with('state', $state);
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
        $store = $this->store;
        $store->name = $request['name'];
        $store->phone_number = $request['phone_number'];
        $store->lat = $request['lat'];
        $store->lng = $request['lng'];
        $store->address = $request['address'];
        $store->city = $request['city'];
        $store->state = $request['state'];
        $store->brands = count($request['brands']) > 0 ? implode(",", $request['brands']) : '';
        $store->save();

        return redirect('stores/'.$store->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $store = $this->store->find($id);
        if (is_null($store))
        {
            return redirect('stores')->with('message', 'Store not found.');
        }
        return view('store.show', $store->toArray());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $store = $this->store->find($id);
        if (is_null($store))
        {
            return redirect('stores')->with('message', 'Store not found.');
        }
        return view('store.edit', $store->toArray())->with('states', $this->store->getStates());
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
        $store = $this->store->find($id);
        if (is_null($store))
        {
            return redirect('stores')->with('message', 'Store not found.');
        }
        $store->name = $request['name'];
        $store->phone_number = $request['phone_number'];
        $store->brands = count($request['brands']) > 0 ? implode(",", $request['brands']) : '';
        $store->lat = $request['lat'];
        $store->lng = $request['lng'];
        $store->address = $request['address'];
        $store->city = $request['city'];
        $store->state = $request['state'];
        $store->save();

        return redirect('stores/'.$store->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $store_id = $request['store_id'];
        $store = $this->store->findOrFail($store_id);
        $storeName = $store->name;
        $this->store->destroy($store_id);

        return redirect('stores')->with('message', 'Successfully deleted \''.$storeName.'\'');
    }
}

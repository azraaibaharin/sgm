<?php

namespace App\Traits;

use Illuminate\Http\Request;

use App\Store;

trait FiltersStore {

    /**
     * An instance of Store.
     *
     * @var \App\Store
     */
    protected $store;

    /**
     * Default constructor.
     *
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }
	
    /**
     * Returns a collection of stotes filtered by state and ordered by created date.
     * 
     * @param  String $state store state
     * @return Collection filtered stores
     */
    public function getStoresByState(String $state, int $count)
    {
        $states = $this->store->getStatesOptions();
        return $this->store->when($state != $states[0], function ($query) use ($state) {
            return $query->where('state', $state);
        }, function ($query) {
            return $query->orderBy('name');
        })->orderBy('name', 'asc')->get();
    }
}
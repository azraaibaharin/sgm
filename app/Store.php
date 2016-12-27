<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'name' => '',
        'phone_number' => '',
    	'lat' => '',
    	'lng' => '',
    	'address' => '',
    	'city' => '',
    	'state' => '',
    	'brands' => '', // comma seprated brands.
    ];

    /**
     * The state options in Malaysia.
     *
     * @var array
     */
    protected $states = [
        'Johor',
        'Kedah',
        'Kelantan',
        'Malacca',
        'Negeri Sembilan',
        'Pahang',
        'Penang',
        'Perak',
        'Perlis',
        'Sabah',
        'Sarawak',
        'Selangor',
        'Terengganu',
        'Kuala Lumpur',
        'Labuan',
        'Putrajaya'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'location', 'address', 'phone_number', 'brands'
    ];

    /**
     * Return sorted states option.
     *
     * @return array sorted states
     */
    public function getStates() 
    {
        $states = $this->states;
        sort($states);
        return $states;
    }

    /**
     * Return sorted states option with the default 'All' option.
     *
     * @return array sorted states
     */
    public function getStatesOptions()
    {
        return $this->getSelectOptions($this->getStates());
    }

    /**
     * Sorts array and add options for select field.
     *
     * @param  Array    $array  array to populate and sort
     * @param  boolean  $defaut whether the default 'All' option should be included
     * @return array        sorted and populated array
     */
    private function getSelectOptions($array, $default = true)
    {
        $sortedPopulatedArr = $array;
        sort($sortedPopulatedArr);
        if ($default)
        {
            array_unshift($sortedPopulatedArr, "All");            
        }

        return $sortedPopulatedArr;
    }
}

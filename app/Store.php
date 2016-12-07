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
    	'location' => '',
    	'address' => '',
    	'phone_number' => '',
    	'brands' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 'location', 'address', 'phone_number', 'brands'
    ];
}

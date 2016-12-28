<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    /**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'full_name' => '',
    	'email' => '',
    	'phone_number' => '',
        'address' => '',
    	'product_model_name' => '',
    	'product_serial_number' => '',
    	'date_of_manufacture' => '',
    	'date_of_purchase' => '',

    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'full_name', 'email', 'phone_number', 'address', 'product_model_name', 
    	'product_serial_number', 'date_of_manufacture', 'date_of_purchase'
    ];
}

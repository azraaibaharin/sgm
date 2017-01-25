<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'discount' => '',
    	'value' => '',
        'date_of_expiration' => '',
    	'date_of_issue' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'discount',
		'value',
		'date_of_expiration',
		'date_of_issue'
    ];
}

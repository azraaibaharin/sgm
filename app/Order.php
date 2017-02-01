<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class Order extends Model
{
    /**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'name' => '',
    	'email' => '',
    	'address' => '',
    	'phone_number' => '',
    	'delivery_cost' => 0.00,
        'coupon_total_value' => 0.00,
    	'status' => '',
    	'shoppingcart_id' => ''
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'name', 
    	'email', 
    	'address', 
    	'phone_number', 
    	'delivery_cost',
        'coupon_total_value',
        'status',
    	'shoppingcart_id'
    ];

    public function since()
    {
        $created = $this->attributes['created_at'];
        $createdDt = new Carbon($created);
        return $createdDt->diffForHumans(Carbon::now());
    }
}

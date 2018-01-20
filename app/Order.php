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
    	'shoppingcart_id' => '',
        'contents' => ''
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
    	'shoppingcart_id',
        'contents'
    ];

    /**
     * Return a human readable string for the difference between created at date and current date.
     * @return String a human readable string for the difference between created at date and current date
     */
    public function since()
    {
        $created = $this->attributes['created_at'];
        $createdDt = new Carbon($created);
        return $createdDt->diffForHumans(Carbon::now());
    }

    /**
     * Scope a query to only include order of a given reference number.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @param  String $refNo the order reference number 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfRefNo($query, $refNo)
    {
        return $query->where('reference_number', $refNo);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    /**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'key' => '',
    	'value' => ''
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'key', 'value'
    ];

    /**
     * Return result of shipping rate east per kilo configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRateEastPerKilo($query)
    {
        return $query->where('key', 'shipping_rate_east_per_kilo');
    }

    /**
     * Return result of shipping rate east min charge configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRateEastMinCharge($query)
    {
        return $query->where('key', 'shipping_rate_east_min_charge');
    }

    /**
     * Return result of shipping rate east min weight configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRateEastMinWeight($query)
    {
        return $query->where('key', 'shipping_rate_east_min_weight');
    }

    /**
     * Return result of shipping rate west per kilo configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRateWestPerKilo($query)
    {
        return $query->where('key', 'shipping_rate_west_per_kilo');
    }

    /**
     * Return result of shipping rate west min charge configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRateWestMinCharge($query)
    {
        return $query->where('key', 'shipping_rate_west_min_charge');
    }

    /**
     * Return result of shipping rate west min weight configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRateWestMinWeight($query)
    {
        return $query->where('key', 'shipping_rate_west_min_weight');
    }

    /**
     * Return result of sales email configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeEmailSales($query)
    {
        return $query->where('key', 'email_sales');
    }
}

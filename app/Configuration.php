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
     * Return result of shipping rate per kilo configuration.
     * 
     * @param  $query
     * @return 
     */
    public function scopeShippingRatePerKilo($query)
    {
        return $query->where('key', 'shipping_rate_per_kilo');
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

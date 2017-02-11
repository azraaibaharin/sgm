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

    /**
     * Scope a query to get the first coupon of the given code.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @param  String $code
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCode($query, $code)
    {
        return $query->where('code', $code);
    }
}

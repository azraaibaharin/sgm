<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'title' => '',
    	'text' => '',
    	'product_id' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title', 'text', 'product_id'
    ];

    /**
     * Get the product that owns the testimonial.
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}

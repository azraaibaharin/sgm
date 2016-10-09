<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	/**
	 * The attributes default values.
	 * 
	 * @var array
	 */
	protected $attributes = [
		'brand' => '', 
		'model' => '',
		'description' => '', 
		'category_id' => '', 
		'image_links' => '', 
		'video_links' => '',
    	'color' => '', 
    	'download_links' => '', 
    	'weight' => '', 
    	'dimension' => '', 
    	'weight_capacity' => '', 
    	'age_requirement' => '',
    	'awards' => '',
	];

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
    protected $fillable = [
    	'brand', 'model', 'description', 'category_id', 'image_links', 'video_links',
    	'color', 'download_links', 'weight', 'dimension', 'weight_capacity', 'age_requirement',
    	'awards'
    ];
}

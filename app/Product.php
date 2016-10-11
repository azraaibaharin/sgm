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
		'category' => '',
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
    	'brand', 'model', 'description', 'category_id', 'category', 'image_links', 'video_links',
    	'color', 'download_links', 'weight', 'dimension', 'weight_capacity', 'age_requirement',
    	'awards'
    ];

    public $brands = [
    	'babyhood', 'nuna'
    ];

    public $categories = [
    	'accessories', 'high chair', 'strollers', 'swingers', 'portable cot/playpen', 'car seat', 
    	'amani bebe', 'bassinettes', 'bed and bath', 'change mats', 'feeding', 'furniture',
    	'baby cots', 'bedguard', 'change table', 'chest drawers', 'glider feeding chair', 'kaylula',
    	'bedding accessories ', 'baby cots', 'cradle', 'chest drawers', 'mattresses', 'portable cots', 
    	'strollers', 'travel time', 'walkers, rockers, bouncinette',
    ];

    /**
     * Get link to display image.
     *
     * @return String link to image
     */
    public function getDisplay() 
    {
    	$imagesArr = explode(',', $this->attributes['image_links']);
    	foreach ($imagesArr as $image) {
    		if (!is_null($image) && !empty($image))
    		{
    			return $image;
    		}
    	}

    	return '';
    }
}

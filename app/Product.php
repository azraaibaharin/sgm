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
        'price' => '',
		'description' => '', 
        'status' => '',
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
        'delivery_weight' => 0.00
	];

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
    protected $fillable = [
    	'brand', 'model', 'price', 'description', 'category_id', 'category', 'image_links', 'video_links',
    	'status', 'color', 'download_links', 'weight', 'dimension', 'weight_capacity', 'age_requirement',
    	'awards', 'delivery_weight'
    ];

    /**
     * Available brands.
     *
     * @var array
     */
    protected $brands = [
    	'babyhood', 'nuna'
    ];

    /**
     * Product categories.
     * 
     * @var array
     */
    protected $categories = [
    	'accessories', 'high chair', 'swinger', 'playpen', 'car seat', 
    	'amani bebe', 'bassinettes', 'bed and bath', 'change mat', 'feeding', 'furniture',
    	'bedguard', 'change table', 'glider feeding chair', 'kaylula',
    	'bedding', 'baby cots', 'cradle', 'chest drawers', 'mattresses', 'portable cot', 
    	'stroller', 'travel time', 'walker, rockers, bouncinette',
    ];

    /**
     * Product status.
     * 
     * @var array
     */
    protected $statuses = [
        'In Stock', 'Out of Stock'
    ];

    /**
     * Get the testimonials for the product.
     */
    public function testimonials()
    {
        return $this->hasMany('App\Testimonial');
    }

    /**
     * Returns an array of statuses.
     *
     * @return array statuses
     */
    public function getStatuses()
    {
        $array = $this->statuses;
        sort($array);
        return $array;
    }

    /**
     * Returns an array of categories.
     *
     * @param default boolean value to indicates whether a default 'All' value is required
     * @return array categories
     */
    public function getCategories($default = true)
    {
        return $this->getSelectOptions($this->categories, $default);
    }

    /**
     * Return an array of brands.
     *
     * @param default boolean value to indicates whether a default 'All' value is required
     * @return array brands
     */
    public function getBrands($default = true)
    {
        return $this->getSelectOptions($this->brands, $default);
    }

    /**
     * Sorts array and add options for select field.
     *
     * @param  Array  	$array 	array to populate and sort
     * @param  boolean 	$defaut whether the default 'All' option should be included
     * @return array        sorted and populated array
     */
    private function getSelectOptions($array, $default = true)
    {
    	$sortedPopulatedArr = $array;
    	sort($sortedPopulatedArr);
        if ($default)
        {
            array_unshift($sortedPopulatedArr, "All");            
        }

        return $sortedPopulatedArr;
    }

    /**
     * Get an array of image links.
     *
     * @return array image links
     */
    public function getImages()
    {
    	return preg_split('/,/', $this->attributes['image_links'], -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Get an array of video links.
     *
     * @return array video links
     */
    public function getVideos()
    {
    	return preg_split('/,/', $this->attributes['video_links'], -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Get display link.
     *
     * @return String link to display
     */
    public function getDisplay($attribute) 
    {
    	$display = '';
    	$array = preg_split('/,/', $this->attributes[$attribute], -1, PREG_SPLIT_NO_EMPTY);
    	if (sizeof($array) > 0) 
    	{
	    	$display = $array[0];
	    }
    	return $display;
    }
}

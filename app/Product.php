<?php

namespace App;

use Auth;
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
        'delivery_weight' => 0.00,
        'visible' => true,
        'tag' => '',
        'sort_index' => '99999',
        'is_sale' => false,
	];

	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
    protected $fillable = [
    	'brand', 'model', 'price', 'description', 'category_id', 'category', 'image_links', 'video_links',
    	'status', 'color', 'download_links', 'weight', 'dimension', 'weight_capacity', 'age_requirement',
    	'awards', 'delivery_weight', 'visible', 'tag', 'sort_index', 'is_sale'
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
    	'stroller', 'travel time', 'walker, rockers, bouncinette', 'package'
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
     * Scope a query to only include products of a given brand.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @param  String $brand 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfBrand($query, $brand)
    {
        $q = $query;

        if ($brand != $this->getBrands()[0])
        {
            $q = $q->where('brand', $brand);
        }

        if (Auth::guest())
        {
            $q = $q->where('visible', true);
        }

        return $q->orderBy('updated_at', 'asc');
    }

    /**
     * Scope a query to only include products of a given brand and category.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder $query 
     * @param  String $brand 
     * @param  String $category 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfBrandAndCategory($query, $brand, $category)
    {
        $q = $query;

        if (!is_null($brand) && $brand != $this->getBrands()[0])
        {
            $q = $q->where('brand', $brand);
        }

        if (!is_null($category) && $category != $this->getCategories()[0])
        {
            $q = $q->where('category', $category);
        }

        if (Auth::guest())
        {
            $q = $q->where('visible', true);
        }

        return $q->orderBy('is_sale', 'desc')
                 ->orderBy('sort_index', 'desc')
                 ->orderBy('model', 'asc');
    }

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
